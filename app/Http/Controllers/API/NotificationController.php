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

    public function readNotification($id){
        //marking the notification with id to read
        $notification = Notifications::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        //retreving notification message based on notification id
        return redirect('/credit-wallet')->with('notify', $notification->message);
    }
}
