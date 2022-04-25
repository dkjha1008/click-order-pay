<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract {

    public function toResponse($request) {		
		if(auth()->check() && auth()->user()->status == '0'){
            auth()->logout();
			alert()->error('Your Account has been disabled', 'Oops');
            return redirect()->route('login');
        }
		$redirectUrl = session('link');
		session(['link' => '']);
		
		if(auth()->user()->role=='admin'){
			return redirect()->route('admin');
		}
        return redirect($redirectUrl);
    }
}