<?php
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationRecipient;

function sendNotification($type, $message, $roles =[])
{
    // create notification
    $notification = Notification::create([
        'type' => $type,
        'message' => $message
    ]);

    // find users by role
    $users = User::whereHas('role', function ($query) use ($roles){
        $query->whereIn('name', $roles);
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
