<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Validator;

class AuthController extends Controller
{
	
    //...
	public function loginForm()
	{
	
		return Inertia::render('Auth/Signin');
	}
	
	//...
	public function loginVerify(Request $request)
	{
		$user = User::where('phone_number', $request->phone_number)->first();
		
		if(@$user){
			//create user
			
			if (!(Hash::check($request->password, $user->password))) {
				return response(['type'=>'error', 'message'=>'Invalid credientials']);
			}
			
			if($user->status == '2'){
				return response(['type'=>'error', 'message'=>'Your account is blocked']);
			}
			if($user->status == '0'){
				return response(['type'=>'error', 'message'=>'Your account is not active']);
			}

			if(!$user->verified_at){
				if(@$request->otp){
					if($request->otp!=$user->otp){
						return response(['type'=>'error', 'message'=>'Invalid Code']);
					}
					return response(['type'=>'success', 'message'=>'Success', 'otp'=>false]);
				}
				else {
					$otp = rand(100000, 999999);
					$message = 'Your OTP: '.$otp;
					
					$res = message($request->phone_number, $message);
					
					if(@$res){
						$user->otp = $otp;
						$user->save();
						
						return response(['type'=>'success', 'message'=>'Phone number not verifies', 'otp'=>true]);
					}
					return response(['type'=>'error', 'message'=>'Server error! Try again']);
				}
			}
		
			return response(['type'=>'success', 'message'=>'Success', 'otp'=>false]);
		}
		else {
			return response(['type'=>'error', 'message'=>'Invalid phone number']);
		}
	}
	
	//...
	public function login()
	{
		Auth::attempt(
			InertiaRequest::validate([
				'phone_number' => ['required', 'digits_between:10,12'],
				'password' => ['required', 'min:6'],
			])
		);
		
		if(Auth::check()==true){
			$user = Auth::user();
			if(!$user->verified_at){
				$user->verified_at = date('Y-m-d H:i:s');
			}
			$user->otp = '';
			$user->save();
			return Redirect::route('move');
			return Redirect::route('ucla')->with('success', 'Welcome Back.');

		}
		else {
			return Redirect::back()->with('error', 'Incorrect Credentials');
		}
	}
	
	//...
	public function logout()
	{
		Auth::logout();
		return Redirect::route('signin')->with('success', 'Logout Success');
	}
	
	//...
	public function signupForm()
	{
		return Inertia::render('Auth/Signup');
	}
	
	//...
	public function signup(Request $request)
	{
		
		$check = User::where('phone_number', $request->phone_number)->count();
		
		if($check>0){
			return response(['type'=>'error', 'message'=>'Phone number already exist']);
		}
		
		if(strlen(trim($request->password)) <= 6){
			return response(['type'=>'error', 'message'=>'Password must be 6 characters']);
		}
		
		if(strlen(trim($request->password)) != strlen(trim($request->password_confirmation))){
			return response(['type'=>'error', 'message'=>'Confirm password not match with password']);
		}
		
		
		try {
			//create user
			$otp = rand(100000, 999999);
			
			$message = 'Your OTP: '.$otp;
			$res = message($request->phone_number, $message);
			
			if(@$res){
				$user = new User;
				$user->phone_number = $request->phone_number;
				$user->email = $request->email;
				$user->password = Hash::make($request->password);
				$user->otp = $otp;
				$user->save();
				
				return response(['type'=>'success', 'message'=>'Code is send to your mobile number please fill it verify your account']);
			}
			return response(['type'=>'error', 'message'=>'Invalid Phone Number']);
		}
		catch(\Exception $e) {
			return response(['type'=>'error', 'message'=>$e->getMessage()]);
		}
		
		
	}
	
	
	//---
	
	public function signupOtp(Request $request){
		
		$check = User::where('phone_number', $request->phone_number)->first();
	
		if(@$check){
			if($check->otp == $request->otp){
				$check->otp = '';
				$check->verified_at = date('Y-m-d H:i:s');
				$check->save();
				
				//---
				Auth::attempt(
					InertiaRequest::validate([
						'phone_number' => ['required'],
						'password' => ['required'],
					])
				);
		
				return Redirect::route('ucla')->with('success', 'Your account is verified successfully.');
			}
			return Redirect::back()->with('error', 'Invalid Code');
		}
		return Redirect::back()->with('error', 'Server error');
		
		
	}
	
	
	//...
	public function forgotForm()
	{
		return Inertia::render('Auth/Forgot');
	}
	
	//...
	public function password(Request $request)
	{
		$user = User::where('phone_number', $request->phone_number)->first();
		
		if(@$user){
			//create user
			
			if($request->type=='forgot'){
				$otp = rand(100000, 999999);
				$message = 'Your OTP: '.$otp;
				
				$res = message($request->phone_number, $message);
				
				if(@$res){
					$user->otp = $otp;
					$user->save();
					
					return response(['type'=>'success', 'message'=>'6 Digit code is sent to registered mobile number please fill it to reset your password']);
				}
				return response(['type'=>'error', 'message'=>'Invalid Phone Number']);
			}
			
			if($request->type=='otp'){
				if($user->otp == $request->otp){
					return response(['type'=>'success', 'message'=>'Code Verified']);
				}
				return response(['type'=>'error', 'message'=>'Invalid Code']);			
			}
			
			if($request->type=='password'){
				if(strlen(trim($request->password)) <= 6){
					return response(['type'=>'error', 'message'=>'Password must be 6 characters']);
				}
				
				if(strlen(trim($request->password)) != strlen(trim($request->password_confirmation))){
					return response(['type'=>'error', 'message'=>'Confirm password not match with password']);
				}
				
				$user->password = Hash::make($request->password);
				if(!$user->verified_at){
				$user->verified_at = date('Y-m-d H:i:s');
				}
				$user->otp = '';
				$user->save();
				
				return response(['type'=>'success', 'message'=>'Password Changed']);
			}			
		}
		else {
			return response(['type'=>'error', 'message'=>'Invalid Phone Number']);		
		}
	}
	
	//...
	public function passwordInertia(Request $request)
	{
		$user = User::where('phone_number', $request->phone_number)->first();
		
		if(@$user){
			//...
			if($request->type=='password'){
				if(strlen(trim($request->password)) <= 6){
					return Redirect::back()->with('error', 'Password must be 6 characters');
				}
				
				if(strlen(trim($request->password)) != strlen(trim($request->password_confirmation))){
					return Redirect::back()->with('error', 'Confirm password not match with password');
				}
				
				$user->password = Hash::make($request->password);
				if(!$user->verified_at){
				$user->verified_at = date('Y-m-d H:i:s');
				}
				$user->otp = '';
				$user->save();
				
				return Redirect::route('signin')->with('error', 'Password Changed');
			}			
		}
		else {
			return Redirect::back()->with('error', 'Invalid Phone Number');
		}
	}
	

	public function resendOtp(Request $request){
		$user = User::where('phone_number', $request->phone_number)->first();
		
		if(@$user){
			$otp = rand(100000, 999999);
				$message = 'Your OTP: '.$otp;
				
				$res = message($request->phone_number, $message);
				
				if(@$res){
					$user->otp = $otp;
					$user->save();
					
					return response(['type'=>'success', 'message'=>'6 Digit code is sent to registered mobile number please fill it to reset your password']);
				}
				return response(['type'=>'error', 'message'=>'Invalid Phone Number']);
		}
		else {
			return Redirect::back()->with('error', 'Invalid Phone Number');
		}
	}

}
