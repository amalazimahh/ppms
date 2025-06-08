<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';

    /**
     * Override the reset method to store the request for admin approval
     */
    public function reset(Request $request)
    {
        // Debug the incoming request data
        \Log::info('Password reset request received', ['email' => $request->email]);
        
        try {
            $request->validate($this->rules(), $this->validationErrorMessages());
            
            // find the user by email
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                \Log::warning('User not found for password reset', ['email' => $request->email]);
                return back()->withErrors(['email' => 'User not found']);
            }
            
            // store the password reset request
            $resetRequest = PasswordResetRequest::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'new_password' => Hash::make($request->password),
                'status' => 'pending'
            ]);
            
            \Log::info('Password reset request created', ['id' => $resetRequest->id]);
            
            // send notification to admin
            sendNotification(
                'reset_password',
                "User {$user->name} ({$user->email}) has requested a password reset.",
                ['Admin']
            );
            
            return redirect()->back()->with('status', 'Reset password request sent to Admin. Please wait for approval status.');
        } catch (\Exception $e) {
            \Log::error('Error in password reset', ['error' => $e->getMessage()]);
            return back()->withErrors(['general' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function showDirectResetForm()
    {
        return view('auth.passwords.reset');
    }

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'password.min' => 'Password must be at least 8 characters',
        ];
    }
}
