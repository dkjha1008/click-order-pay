<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract {

    public function toResponse($request) {
        $redirectUrl = session('link');
		session(['link' => '']);
        return redirect($redirectUrl);
    }
}