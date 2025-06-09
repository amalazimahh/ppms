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

    $query = Notification::whereHas('recipients', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    });

    \Log::info('Initial Query:', ['query' => $query->toSql()]);

    // filter by type
    if ($request->has('type') && $request->type !== '') {
        $query->where('type', $request->type);
        \Log::info('Type Filter Added:', ['type' => $request->type]);
    }

    // filter by read status
    if ($request->has('status')) {
        $isRead = $request->status === 'read';
        $query->whereHas('recipient', function ($q) use ($isRead) {
            $q->where('read', $isRead);
        });
    }

    $notifications = $query->orderBy('created_at', 'desc')->paginate(10);

    if ($request->ajax()) {
        return response()->json([
            'notifications' => $notifications->items(),
            'links' => $notifications->links()->toHtml(),
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
        Notification::where('id', $id)->update(['read' => true]);
        return back()->with('success', 'Marked as read!');
    }



    public function destroy($id)
    {
        $userId = Auth::id();
        $notification = Notification::where('id', $id)->where('user_id', $userId)->first();
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Notification not found or unauthorized'], 404);
    }

    public function destroyAll() {
        NotificationRecipient::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}
