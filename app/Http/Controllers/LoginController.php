<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Funds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Illuminate\Support\Facades\Request as FacadesRequest;


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
        $user->verification_code = sha1(time());
        $user->save();

        //creates a wallet for newly registered user and send verification mail
        if($user)
        {
            $newWallet = new Funds();
            $newWallet->user_id = $user->id;
            $newWallet->save();

            //send verification mail
            MailController::sendVerificationMail($user->name, $user->email, $user->verification_code);
        }

        //Redirecting back to the register page with a flash message
        return redirect()->back()->with('registered', 'Please check your mail to verify your email address!');
    }

    //verify user
    public function verifyUser(Request $request)
    {
        $verificationCode = FacadesRequest::get('code');
        $user = User::where('verification_code', $verificationCode)->first();

        if($user !== null)
        {
            $user->is_verified = 1;
            $user->save();

            return redirect('/login')->with( session()->flash('verified', 'Your account was verified successfully. Please Login!!!') );
        }
    }


    //Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials))
        {
            if(Auth::user()->is_verified !== 1)
            {
                return redirect()->back()->with('error', 'Your account is not yet verified, please check your email');
            }

            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect()->back()->with('error', 'Did not find your account.');

    }

    //Logout
    public function logout(Request $request)
    {
        //Simply distroying user session
        // session()->flush();
        //redirects you to login page

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
