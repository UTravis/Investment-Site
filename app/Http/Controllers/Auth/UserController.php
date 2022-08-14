<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Getting the logged in user details from the session data
    public static function User()
    {
        //retrieving user email stored in the session
        $userEmail = session()->get('user_session');

        $user = User::where('email', $userEmail)->first();  //retrieving user details
        return $user;
    }


}
