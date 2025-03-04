<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Notification::where('user_id', $user->id);

        // filter by type
        if($request->has('type') && $request->type !== 'all'){
            $query->where('type', $request->type);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.notification', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();

        if ($notification) {
            $notification->update(['read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function destroyAll(){
        Notification::where('user_id', Auth::id())->delete();
        return response()->json(['success'=>true]);
    }
}
