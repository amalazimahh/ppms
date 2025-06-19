<?php
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationRecipient;

function getNotificationRoles($type) {
    $rolesByNotificationType = [
        'new_user' => ['Admin'],
        'reset_password' => ['Admin'],
        'new_project' => ['Admin'],
        'update_project_details' => ['Admin', 'Project Manager'],
        'update_project_status' => ['Admin', 'Project Manager'],
        'upcoming_deadline' => ['Admin', 'Project Manager', 'Executive'],
        'overbudget' => ['Admin', 'Project Manager', 'Executive'],
        'overdue' => ['Admin', 'Project Manager', 'Executive']
    ];

    return $rolesByNotificationType[$type] ?? ['Admin'];
}

function sendNotification($type, $message, $roles = [], $userIds = [])
{
    $notification = Notification::create([
        'type' => $type,
        'message' => $message
    ]);

    // Get users by IDs
    $users = collect();
    if (!empty($userIds)) {
        $users = User::whereIn('id', $userIds)->get();
    }

    // Get users by roles
    $targetRoles = empty($roles) ? getNotificationRoles($type) : $roles;
    $roleUsers = User::whereHas('role', function ($query) use ($targetRoles) {
        $query->whereIn('name', $targetRoles);
    })->get();

    // Merge and remove duplicates
    $allUsers = $users->merge($roleUsers)->unique('id');

    \Log::info('Users found for notification', [
        'count' => $allUsers->count(),
        'ids' => $allUsers->pluck('id')->toArray()
    ]);

    foreach($allUsers as $user) {
        try {
            NotificationRecipient::create([
                'notification_id'=> $notification->id,
                'user_id' => $user->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create NotificationRecipient', [
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    \Log::info('sendNotification called', [
        'type' => $type,
        'message' => $message,
        'userIds' => $userIds,
        'roles' => $roles,
    ]);
}



?>
