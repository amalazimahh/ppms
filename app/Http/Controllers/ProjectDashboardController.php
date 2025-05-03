<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectDashboardController extends Controller
{
    public function projectSpecificDashboard()
    {
        if(session('roles') == 1){
            return view('pages.admin.project-dashboard', ['pageSlug' => 'project-dashboard']);
        } else if(session('roles') == 2){
            return view('pages.project_manager.project-dashboard', ['pageSlug' => 'project-dashboard']);
        } else if(session('roles') == 3){
            return view('pages.executive.project-dashboard', ['pageSlug' => 'project-dashboard']);
        }

    }
    public function index(Request $request){
        $project = null;

        if($request->has('project_name')){
            $project = Project::where('title', 'LIKE', '%' . $request->project_name . '%')->first();
        }

        return view('pages.admin.project-dashboard', compact('project'));
    }
}
