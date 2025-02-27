<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $response)
    {
        // Update all unread notifications to read
        Notification::where('read', false)->update(['read' => true]);
        return response()->json(['success' => true]);

        //return response()->json(['message' => 'All notifications marked as read']);
    }

    /**
     * Fetch only unread notifications.
     *
     * @return \Illuminate\View\View
     */
    public function getNotifications()
    {
        $notifications = Notification::where('get', 0)->get(); // Fetch only unread notifications
        return view('auth', compact('notifications'));
    }
}
