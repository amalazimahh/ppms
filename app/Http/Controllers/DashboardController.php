<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        \Log::info('User role debug', [
            'user_id' => $user->id,
            'role_id_from_user' => $user->role_id,
            'role_from_relation' => $user->role ? $user->role->id : 'No role found',
        ]);

        $totalProjects = Project::count();

        return view('pages.admin.dashboard', compact('totalProjects'));
    }

    public function dashboard()
    {
        $projects = Project::with('rkn')->get(); // eager load RKN relationship
        $totalProjects = Project::count();
        $upcomingDeadlines = [];

        foreach($projects as $project){
            // If project has an RKN assigned, use its endDate as the deadline
            if ($project->rkn && $project->rkn->endDate) {
                $deadline = \Carbon\Carbon::parse($project->rkn->endDate);
            } else {
                // fallback to old logic if no RKN assigned
                $handover = \Carbon\Carbon::parse($project->handoverDate);
                $fyStartYear = $handover->month < 4 ? $handover->year : $handover->year + 1;
                $fyStart = \Carbon\Carbon::create($fyStartYear,4, 1);
                $deadline = $fyStart->copy()->addYears(5)->subDay();
            }

            $now = \Carbon\Carbon::now();
            $diffInMonths = floor($now->diffInMonths($deadline, false));
            $diffInDays =  $now->diffInDays($deadline, false);

            // assign traffic light color for deadline
            if($diffInMonths > 2){
                $status = 'success'; // green
            } elseif($diffInMonths == 2){
                $status = 'warning'; // yellow
            } else if($diffInMonths < 1){
                $status = 'danger'; // red
            } else {
                $status = 'success'; // green
            }

            $upcomingDeadlines[] = [
                'name' => $project->title,
                'deadline' => $deadline->format('d-m-Y'),
                'months_left' => $diffInMonths,
                'status' => $status
                // 'budget' => $project->budget_status
            ];
        }

        return view('pages.admin.dashboard', compact('projects', 'totalProjects', 'upcomingDeadlines'));
    }

}
