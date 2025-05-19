<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request, $user){

        // Store role in session
        session(['roles' => $user->roles_id]);

        // Fetch role ID from user
        \Log::info('User details', [
            'user_id' => $user->id,
            'roles_id' => session('roles')
        ]);

        if ($user->roles_id == 1) {
            session()->flash('welcome', 'Welcome Back, you are currently logged in as Admin.');
            return redirect('/admin/dashboard');
        } elseif ($user->roles_id == 2) {
            session()->flash('welcome', 'Welcome Back, you are currently logged in as Project Manager.');
            return redirect('/project_manager/dashboard');
        } elseif ($user->roles_id == 3) {
            session()->flash('welcome', 'Welcome Back, you are currently logged in as Executive.');
            return redirect('/executive/dashboard');
        }

        return redirect('/home');
    }

    protected function redirectTo()
    {
        if(Auth::check()){
            $roleId = Auth::user()->roles_id;

            \Log::info('Redirecting user', ['roles_id' => $roleId]);

            if($roleId === 1){
                return '/admin/dashboard';
            } elseif($roleId === 2){
                return '/project_manager/dashboard';
            } elseif($roleId === 3){
                return '/executive/dashboard';
            }
        }

        return '/home';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
