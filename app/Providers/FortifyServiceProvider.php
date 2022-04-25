<?php

namespace App\Providers;

//use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	
		Fortify::loginView(function (Request $request) {
			if ($request->redirect==true) {
                session(['link' => url()->previous()]);
            } else {                
				$myPath = url('/');
                session(['link' => $myPath]);
            }
			
			$title = array(
				'title' => 'Login',
				'active' => 'login'
			);
			return view('auth.login', compact('title'));
		});

		Fortify::authenticateUsing(function (Request $request) {
			$user = User::where('email', $request->email)->first();
			
			if(@$request->redirect==true){
				session(['link' => url()->previous()]);
			}
			if ($user &&
				Hash::check($request->password, $user->password)) {				
				return $user;
			}
		});
		
		
		Fortify::requestPasswordResetLinkView(function () {
			$title = array(
				'title' => 'Forgot Password',
				'active' => 'forgot'
			);
			return view('auth.forgot-password', compact('title'));
		});

		Fortify::resetPasswordView(function ($request) {
			$title = array(
				'title' => 'Reset Password',
				'active' => 'forgot'
			);
			return view('auth.reset-password', compact('title', 'request'));
		});

		Fortify::verifyEmailView(function () {
			$title = array(
				'title' => 'Verify Email',
				'active' => 'verify'
			);
			return view('auth.verify-email', compact('title'));
		});
	
        //Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);		
		
		// register new LoginResponse & RegisterResponse
		$this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class,
        );
		
		// $this->app->singleton(
            // \Laravel\Fortify\Contracts\RegisterResponse::class,
            // \App\Http\Responses\RegisterResponse::class
        // );
    }
}
