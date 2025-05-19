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
        $user = Auth::user();

        if(session('roles') == 1 || session('roles') == 3){
            // calculate the upcoming deadlines of projects
            $projects = Project::with(['rkn', 'milestones'])->get();
            $totalProjects = Project::count();
            $upcomingDeadlines = [];
            $completedCount = 0;
            $ongoingCount = 0;
            $overdueCount = 0;
            $ministries = ClientMinistry::with('projects')->get();
            $mainProjects = Project::whereNull('parent_project_id')->get();

            foreach($projects as $project){
                // if project has an RKN assigned, use endDate as the deadline
                if ($project->rkn && $project->rkn->endDate) {
                    $deadline = \Carbon\Carbon::parse($project->rkn->endDate);
                } else {
                    // if no RKN assigned then use default date
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

                // Fetch oic from project_team
                $oic = \DB::table('project_team')
                    ->join('users', 'project_team.officer_in_charge', '=', 'users.id')
                    ->where('project_team.project_id', $project->id)
                    ->value('users.name');

                $upcomingDeadlines[] = [
                    'name' => $project->title,
                    'main_project' => $project->parent_project_id
                        ? optional(Project::find($project->parent_project_id))->title
                        : null,
                    'deadline' => $deadline->format('d-m-Y'),
                    'months_left' => $diffInMonths,
                    'status' => $status,
                    'officer_in_charge' => $oic ?? 'N/A'
                ];
            }

            // calculate total sch and av
            $schemeValue = Project::sum('sv');
            $allocationValue = Project::sum('av');

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

            // data for bar chart (financial and physical progress)
            $projectNames = [];
            $physicalProgress = [];
            $financialProgress = [];

            foreach ($projects as $project) {
                $projectNames[] = $project->title;
                $physicalProgress[] = $project->physical_progress ?? 0;
                $financialProgress[] = $project->financial_progress ?? 0;
            }

            return view('pages.admin.dashboard', compact(
                'projects',
                'totalProjects',
                'upcomingDeadlines',
                'completedCount',
                'ongoingCount',
                'overdueCount',
                'schemeValue',
                'allocationValue',
                'ministries',
                'sunburstData',
                'stageLabels',
                'stageData',
                'projectNames',
                'physicalProgress',
                'financialProgress'
            ));
        } else if(session('roles') == 2){
            return view('pages.project_manager.dashboard');
        } else {
            return view('pages.dashboard');
        }
    }

}
