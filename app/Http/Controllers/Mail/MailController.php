<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public static function sendVerificationMail($name, $email, $verificationCode)
    {
        $data = [
            'name' => $name,
            'verification_code' => $verificationCode
        ];

        Mail::to($email)->send(new VerifyUser($data));
    }
}
