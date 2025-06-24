<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Project;
use App\Helpers\NotificationHelper;

class NotificationController extends Controller
{

    public function index(Request $request)
{
    $user = Auth::user();
    $role = $user->role_id ?? session('roles');

    if ($role == 1) {
        $query = Notification::whereHas('recipients', function ($q) {
            $q->where('user_id', 1);
        });
    } elseif ($role == 3) {
        $query = Notification::whereHas('recipients', function ($q) {
            $q->where('user_id', 3);
        });
    } else {
        $query = Notification::whereHas('recipients', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    \Log::info('Initial Query:', ['query' => $query->toSql()]);

    // filter by type
    if ($request->has('type') && $request->type !== '') {
        $query->where('type', $request->type);
        \Log::info('Type Filter Added:', ['type' => $request->type]);
    }

    // filter by read status
    if ($request->has('status')) {
        $isRead = $request->status === 'read';
        $query->whereHas('recipients', function ($q) use ($isRead) {
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
        $recipient = \App\Models\NotificationRecipient::where('notification_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($recipient) {
            $recipient->delete();
            return redirect()->back()->with('success', 'Notification deleted!');
        }
        return redirect()->back()->with('error', 'Notification not found or unauthorized');
    }

    public function destroyAll() {
        NotificationRecipient::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Notification deleted!');
    }

    public function sendProjectDeadlineNotifications()
    {
        // Loop through projects
        $now = Carbon::now();
        $projects = Project::all();

        foreach ($projects as $project) {
            if (!$project->deadline) continue;
            $now = \Carbon\Carbon::now();
            $deadline = \Carbon\Carbon::parse($project->deadline);
            $diffInMonths = $now->diffInMonths($deadline, false);
            $title = $project->parentProject ? $project->parentProject->title : $project->title;

            if ($diffInMonths > 0 && $diffInMonths <= 2) {
                // Notify only project managers of this project
                $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
                sendNotification(
                    'upcoming_deadline',
                    "Project '{$project->title}' is approaching its deadline in {$diffInMonths} month(s).",
                    ['Admin', 'Project Manager', 'Executive'], // roles
                    $userIds // userIds
                );
            }

            if ($now->greaterThan($deadline)) {
                $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
                sendNotification(
                    'overdue',
                    "Project '{$project->title}' is overdue.",
                    ['Admin', 'Project Manager', 'Executive'], // roles
                    $userIds
                );
            }
        }
    }

    public function notifyNewProject($project)
    {
        $title = $project->parentProject ? $project->parentProject->title : $project->title;
        sendNotification(
            'new_project',
            "A new project '{$project->title}' has been created.",
            ['Admin']
        );
    }

    public function notifyNewUser($user)
    {
        sendNotification(
            'new_user',
            "A new user '{$user->name}' has registered.",
            ['Admin']
        );
    }

    public function notifyResetPassword($user)
    {
        sendNotification(
            'reset_password',
            "User '{$user->name}' has requested a password reset.",
            ['Admin']
        );
    }

    public function notifyUpdateProjectDetails($project)
    {
        $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
        $title = $project->parentProject ? $project->parentProject->title . ' - ' . $project->title : $project->title;
        sendNotification(
            'update_project_details',
            "Project '{$title}' details have been updated.",
            ['Admin', 'Project Manager'],
            $userIds
        );
    }

    public function notifyUpdateProjectStatus($project)
    {
        $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
        $title = $project->parentProject ? $project->parentProject->title . ' - ' . $project->title : $project->title;
        sendNotification(
            'update_project_status',
            "Project '{$title}' status has been updated.",
            ['Admin', 'Project Manager'],
            $userIds
        );
    }

    public function notifyOverbudget($project)
    {
        $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
        $title = $project->parentProject ? $project->parentProject->title . ' - ' . $project->title : $project->title;
        sendNotification(
            'overbudget',
            "Project '{$title}' is over budget.",
            ['Admin', 'Project Manager', 'Executive'],
            $userIds
        );
    }

    public function notifyOverdue($project)
    {
        $userIds = $project->projectTeam->pluck('officer_in_charge')->toArray();
        $title = $project->parentProject ? $project->parentProject->title . ' - ' . $project->title : $project->title;
        sendNotification(
            'overdue',
            "Project '{$title}' is overdue.",
            ['Admin', 'Project Manager', 'Executive'],
            $userIds
        );
    }
}
