<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function loginPage()
    {
        return view('auth/login');
    }

    public function login()
    {
        // À implémenter plus tard
        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
