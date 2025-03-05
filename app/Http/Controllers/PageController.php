<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

class PageController extends Controller
{
    /**
     * Display add new projects page
     *
     * @return \Illuminate\View\View
     */

    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function rtl()
    {
        return view('pages.rtl');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }

    /**
     * Display the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    // public function dashboard()
    // {
    //     $user = Auth::user();
    //     $role = DB::table('roles')->where('id', $user->role_id)->value('name');

    //     if($role === 'Admin'){
    //         return view('pages.admin.dashboard');
    //     } elseif ($role === 'Project Manager'){
    //         return view('pages.project_manager.dashboard');
    //     } elseif($role === 'Executive'){
    //         return view('pages.executive.dashboard');
    //     }

    //     return redirect()->route('home');
    // }

    public function adminDashboard()
    {
        $user = Auth::user();
        \Log::info('User role debug', [
            'user_id' => $user->id,
            'role_id_from_user' => $user->role_id,
            'role_from_relation' => $user->role ? $user->role->id : 'No role found',
        ]);

        if (session('roles') == 1) {
            return view('pages.admin.dashboard');
        }

        return redirect()->route('home'); // Redirect if not an admin
    }

    public function projectSpecificDashboard()
    {
        return view('pages.admin.project-dashboard', ['pageSlug' => 'project-dashboard']);
    }

    public function projectManagerDashboard()
    {
        $user = Auth::user();

        if (session('roles') == 2) {
            return view('pages.project_manager.dashboard');
        }

        return redirect()->route('home'); // Redirect if not a project manager
    }

    public function executiveDashboard()
    {
        $user = Auth::user();

        if (session('roles') == 3) {
            return view('pages.executive.dashboard');
        }

        return redirect()->route('home'); // Redirect if not an executive
    }

    /**
     * Display add new projects page for PM and Admin only
     */
    public function basicdetails(){
        if(session('roles') == 1){
            return view('pages.admin.forms.basicdetails');
        } elseif (session('roles') == 2){
            return view('pages.project_manager.forms.basicdetails');
        }

        return redirect()->route('home');
    }

    /**
     * Display user management page for admins
     */
    public function manageUsers() {
        $users = DB::table('users')
        ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
        ->select('users.*', 'roles.name as role_name')
        ->get();

        return view('pages.admin.user_management', compact('users'));
    }

    /**
     * Display project dashboard page for pm
     */
    public function projectDashboard(){
        if(session('roles') == 2){
            return view('pages.project_manager.dashboard');
        }

        return redirect()->route('home');
    }

    /**
    * Display project list page for admin
    */
    public function projectList() {
        if(session('roles') == 1){
            return view('pages.admin.projectsList');
        }
        return redirect()->route('home');
    }
}
