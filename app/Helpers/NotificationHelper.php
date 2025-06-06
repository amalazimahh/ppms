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

    return $rolesByNotificationType[$type] ?? ['Admin']; // Default to Admin if type not found
}

function sendNotification($type, $message, $roles = [])
{
    // create notification
    $notification = Notification::create([
        'type' => $type,
        'message' => $message
    ]);

    // Get the roles that should receive this notification type
    $targetRoles = empty($roles) ? getNotificationRoles($type) : $roles;

    // find users by role
    $users = User::whereHas('role', function ($query) use ($targetRoles) {
        $query->whereIn('name', $targetRoles);
    })->get();

    // attach users to the notification
    foreach($users as $user) {
        NotificationRecipient::create([
            'notification_id'=> $notification->id,
            'user_id' => $user->id
        ]);
    }
}

?>
