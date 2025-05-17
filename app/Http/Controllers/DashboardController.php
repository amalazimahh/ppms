<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Status;
use App\Models\ClientMinistry;
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
        // calculate the upcoming deadlines of projects
        $projects = Project::with(['rkn', 'milestones'])->get();
        $totalProjects = Project::count();
        $upcomingDeadlines = [];
        $completedCount = 0;
        $ongoingCount = 0;
        $overdueCount = 0;
        $ministries = ClientMinistry::with('projects')->get();

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

            // milestone logic
            $completedMilestones = $project->milestones()->wherePivot('completed', true)->count();
            if ($completedMilestones == 25) {
                $completedCount++;
            } else {
                $ongoingCount++;
                // overdue: not completed and red status
                if ($status == 'danger') {
                    $overdueCount++;
                }
            }

            $upcomingDeadlines[] = [
                'name' => $project->title,
                'deadline' => $deadline->format('d-m-Y'),
                'months_left' => $diffInMonths,
                'status' => $status
                // 'budget' => $project->budget_status
            ];
        }

        // dynamic sunburst chart data
        $sunburstChildren = [];
        foreach ($ministries as $ministry) {
            $ministryNode = [
                'name' => $ministry->ministryName,
                'children' => []
            ];
            foreach ($ministry->projects as $project) {
                $ministryNode['children'][] = [
                    'name' => $project->title,
                    'value' => 1000
                ];
            }
            if(!empty($ministryNode['children'])){
                $sunburstChildren[] = $ministryNode;
            }
        }

        $sunburstData = [
            'name' => 'flare',
            'children' => $sunburstChildren
        ];

        // group projects by milestone stage for donut chart
        $projects = Project::with('milestones.status')->get();
        $stageCounts = [];
        foreach($projects as $project){
            $milestone = $project->milestone;
            $statusName = $milestone && $milestone->status ? $milestone->status->name : 'Unknown';
            if(!isset($stageCounts[$statusName])){
                $stageCounts[$statusName] = 0;
            }
            $stageCounts[$statusName]++;
        }

        $stageLabels = array_keys($stageCounts);
        $stageData = array_values($stageCounts);

        return view('pages.admin.dashboard', compact(
            'projects',
            'totalProjects',
            'upcomingDeadlines',
            'completedCount',
            'ongoingCount',
            'overdueCount',
            'ministries',
            'sunburstData',
            'stageLabels',
            'stageData'
        ));
    }

}
