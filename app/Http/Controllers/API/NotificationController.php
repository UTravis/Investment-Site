<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function notifications()
    {
        //getting the logged in user
        $user = Auth::user();

        //retrieving the user notifications
        $notifications = Notifications::where('user_id', $user->id)->where('is_read', 0)->get();

        return response()->json($notifications);
    }
}
