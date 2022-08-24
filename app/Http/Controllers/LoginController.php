<?php

namespace App\Http\Controllers;

use App\Models\Funds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\CssSelector\Node\FunctionNode;

class LoginController extends Controller
{
    //Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        //New user instantiation
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        //creates a wallet for newly registered user
        if($user)
        {
            $newWallet = new Funds();
            $newWallet->user_id = $user->id;
            $newWallet->save();
        }

        //Redirecting back to the register page with a flash message
        return redirect()->back()->with('registered', 'You have successfully created an account, please log in');
    }


    //Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        //If user not found or password dosen't match
        if(!$user || ! Hash::check($request->password, $user->password))
        {
            return redirect()->back()->with('error', 'Did not find your account');
        }

        //If user found and password match

            //setting user login session
            $request->session()->put('user_session', $request->email);
            //redirecting to dashboard
            return redirect('/');
    }

    //Logout
    public function logout()
    {
        //Simply distroying user session
        session()->flush();
        //redirects you to login page
        return redirect('/login');
    }
}
