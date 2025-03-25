<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // fetch notifications where the user is a recipient
        $query = Notification::whereHas('recipient', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        // Log the initial query
        \Log::info('Initial Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Log the request data
        \Log::info('Request Data:', ['type' => $request->type]);

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
            // Log the filtered query
            \Log::info('Filtered Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Log the final result
        \Log::info('Notifications:', ['notifications' => $notifications]);

        if ($request->ajax()) {
            return response()->json([
                'notifications' => $notifications->items(),
                'links'=> $notifications->links()->toHtml(),
            ]);
        }

        return view('pages.notification', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $recipient = NotficationRecipient::where('notifications_id', $id)->where('users_id', Auth::id())->first();

        if ($recipient) {
            $recipient->update(['read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function destroyAll(){
        Notification::where('user_id', Auth::id())->delete();
        return response()->json(['success'=>true]);
    }
}
