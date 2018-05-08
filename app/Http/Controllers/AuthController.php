<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        return auth()->guest() ? redirect('saml2/login') : redirect()->intended();
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
