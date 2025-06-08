<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetAdminController extends Controller
{
    // display lists of passsword reset requests
    public function index()
    {
        $requests = PasswordResetRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.password-reset-requests', compact('requests'));
    }

    // approve password reset request
    public function approve($id)
    {
        $resetRequest = PasswordResetRequest::findOrFail($id);
        $user = User::findOrFail($resetRequest->user_id);

        // update the user password
        $user->password = $resetRequest->new_password;
        $user->save();

        // update the request status
        $resetRequest->status = 'approved';
        $resetRequest->save();

        // send notification to the user
        sendNotification(
            'reset_password',
            "Your password reset request has been approved.",
            [],
            [$resetRequest->user_id]
        );

        return redirect()->back()->with('success', 'Password reset request approved successfully.');
    }

    // reject password reset request
    public function reject($id)
    {
        $resetRequest = PasswordResetRequest::findOrFail($id);
        $user = User::findOrFail($resetRequest->user_id);

        // update the request status
        $resetRequest->status = 'rejected';
        $resetRequest->save();

        // send notification to the user
        sendNotification(
            'reset_password',
            "Your password reset request has been rejected.",
            [],
            [$user->id]
        );

        return redirect()->back()->with('success', 'Password reset request rejected successfully.');
    }
}
