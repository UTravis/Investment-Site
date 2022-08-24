<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\UserController;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //Takes you to home
    public function home()
    {
        //getting the logged in user details
        $user = UserController::User();
        $userWallet = User::findOrFail($user->id)->fund; //user wallet detials
        return view('app', compact('user', 'userWallet'));
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

    //Takes you to the credit wallet page
    public function creditWallet()
    {
        $user = UserController::User(); //getting the authenticated user
        $userWallet = User::findOrFail($user->id)->fund; //user wallet detials
        return view('pages.wallet.credit', compact('userWallet', 'user'));
    }
}
