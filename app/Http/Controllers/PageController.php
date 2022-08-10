<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //Takes you to home
    public function home()
    {
        //getting the email from the session and getting the user details from DB
        $userEmail = session()->get('user_session');
        $user = User::where('email', $userEmail)->first();

        return view('app', compact('user'));
    }

    //Takes you to register page
    public function register()
    {
        return view('pages.auth.register');
    }

    //Takes you to login page
    public function login()
    {
        return view('pages.auth.login');
    }
}
