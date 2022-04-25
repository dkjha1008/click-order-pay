<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;

use App\Models\Address;

class ProfileController extends Controller
{
    //...
	public function index(){
		$user = Auth::user();
		$address = Address::where('users_id', $user->id)->first();
		
		$months = months();
		$years = years();
		
		return Inertia::render('Profile', ['user'=>$user, 'months'=>$months, 'years'=>$years, 'address'=>$address]);
	}
	
	//...
	public function update(){
		
		Auth::user()->update(
            InertiaRequest::validate([
                'name' => ['required', 'max:100'],
                'address' => ['required', 'max:255'],
                'notes' => ['nullable', 'max:255'],
                'zip_code' => ['required', 'min:3'],
            ])
        );

        return Redirect::back()->with('success', 'Profile updated.');
	}
	
	//...
	public function addressUpdate(Request $request){		
		InertiaRequest::validate([
			'card_name' => ['required'],
			'card_number' => ['required', 'min:12', 'max:16'],
			'expire_month' => ['required', 'digits:2'],
			'expire_year' => ['required', 'digits:4'],
		]);
		$check = Address::where('users_id', auth()->user()->id)->first();
		
		$store = new Address;
		if(@$check){
			$store->id = $check->id;
			$store->exists = true;
		}
		$store->card_name = $request->card_name;
		$store->card_number = $request->card_number;
		$store->expire_month = $request->expire_month;
		$store->expire_year = $request->expire_year;
		$store->save();

        return Redirect::back()->with('success', 'payment information updated.');
	}
	
	//...
	public function password(){
		return Inertia::render('ChangePassword');
	}
	
	
	//...
	public function passwordUpdate(Request $request)
	{
		InertiaRequest::validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|same:new_password',
            'new_password_confirmed' => 'required|same:new_password',
        ]);

		if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
            // The passwords matches
			return Redirect::back()->with('error', 'Your current password does not matches with the password you provided. Please try again.');
        }
 
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
			return Redirect::back()->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
        }        
 
        //Change Password
        $user = auth()->user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();
 
		return Redirect::route('profile')->with('success', 'Password changed successfully');
	}
	
	
	//............Admin

	public function indexAdmin()
    {
		$title = array(
			'title' => 'Profile',
			'active' => 'profile'
		);
		$user = auth()->user();
        return view('admin.settings.profile', compact('title', 'user'));
    }

    public function updateAdmin(Request $request)
	{
		$user = auth()->user();
		$request->validate([
			'name' => 'required|max:50',
			'email' => 'required|max:100|unique:users,id,'.$user->id,
			'phone_number' => 'required|numeric|digits_between:10,12|unique:users,id,'.$user->id,
        ]);

		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone_number = $request->phone_number;
		$user->save();

		$request->session()->flash('success', "Profile updated successfully");
        return redirect()->back();
	}





	public function passwordAdmin()
    {
		$title = array(
			'title' => 'Change Password',
			'active' => 'profile'
		);
        return view('admin.settings.password', compact('title'));
    }

    public function passwordUpdateAdmin(Request $request)
	{		
		$request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|same:new-password',
            'new-password_confirmed' => 'required|same:new-password',
        ]);

		if (!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            // The passwords matches
			$request->session()->flash('danger', "Your current password does not matches with the password you provided. Please try again.");
			return redirect()->back();
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
			$request->session()->flash('warning', "New Password cannot be same as your current password. Please choose a different password.");
			return redirect()->back();
        }        
 
        //Change Password
        $user = auth()->user();
        $user->password = Hash::make($request->get('new-password'));
        $user->save();
 
		$request->session()->flash('success', "Password changed successfully");
        return redirect()->back();
	}


	public function indexStore()
    {
		$title = array(
			'title' => 'Profile',
			'active' => 'profile'
		);
		$user = auth()->user();
        return view('store.settings.profile', compact('title', 'user'));
    }

    public function updateStore(Request $request)
	{
		$user = auth()->user();
		$request->validate([
			'name' => 'required|max:50',
			'email' => 'required|max:100|unique:users,id,'.$user->id,
			'phone_number' => 'required|numeric|digits_between:10,12|unique:users,id,'.$user->id,
        ]);

		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone_number = $request->phone_number;
		$user->save();

		$request->session()->flash('success', "Profile updated successfully");
        return redirect()->back();
	}





	public function passwordStore()
    {
		$title = array(
			'title' => 'Change Password',
			'active' => 'profile'
		);
        return view('store.settings.password', compact('title'));
    }

    public function passwordUpdateStore(Request $request)
	{		
		$request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|same:new-password',
            'new-password_confirmed' => 'required|same:new-password',
        ]);

		if (!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            // The passwords matches
			$request->session()->flash('danger', "Your current password does not matches with the password you provided. Please try again.");
			return redirect()->back();
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
			$request->session()->flash('warning', "New Password cannot be same as your current password. Please choose a different password.");
			return redirect()->back();
        }        
 
        //Change Password
        $user = auth()->user();
        $user->password = Hash::make($request->get('new-password'));
        $user->save();
 
		$request->session()->flash('success', "Password changed successfully");
        return redirect()->back();
	}
	
}
