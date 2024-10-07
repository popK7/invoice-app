<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notificationList()
    {
        $user = Sentinel::getUser();
        if ($user) {
            $role = $user->roles[0]->slug;
            $userId = $user->id;
            $notifications = Notification::with('user')->where('to_user', $userId)->orderBy('id', 'DESC')->paginate(10);
            $makeNotificationRead = Notification::where('is_read', 0)->update(['is_read' => 1]);
            return view('notifications.notification-list', compact('notifications', 'user', 'role'));
        } else {
            return redirect('/')->with('error', 'Please Login');
        }
    }
}
