<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Contractor;
use App\Models\ClientMinistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageController extends Controller
{

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
     * Display the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get all projects with their relationships
        $projects = Project::with(['rkn', 'milestones', 'physical_status', 'financial_status'])->get();

        // Calculate basic statistics
        $totalProjects = Project::count();
        $completedCount = 0;
        $ongoingCount = 0;
        $overdueCount = 0;

        // Get ministries for sunburst chart
        $ministries = ClientMinistry::with('projects')->get();

        $projectNames = [];
        $physicalProgress = [];
        $financialProgress = [];
        $upcomingDeadlines = [];

        foreach($projects as $project) {
            // Project data for the progress chart
            $projectNames[] = $project->title;
            $physicalProgress[] = $project->physical_status ? $project->physical_status->actual : 0;
            $financialProgress[] = $project->financial_status ? $project->financial_status->actual : 0;

            // Calculate deadline and status
            if ($project->rkn && $project->rkn->endDate) {
                $deadline = Carbon::parse($project->rkn->endDate);
            } else {
                $handover = Carbon::parse($project->handoverDate);
                $fyStartYear = $handover->month < 4 ? $handover->year : $handover->year + 1;
                $fyStart = Carbon::create($fyStartYear, 4, 1);
                $deadline = $fyStart->copy()->addYears(5)->subDay();
            }

            $now = Carbon::now();
            $diffInMonths = floor($now->diffInMonths($deadline, false));

            // Assign traffic light color for deadline
            if($diffInMonths > 2) {
                $status = 'success'; // green
            } elseif($diffInMonths == 2) {
                $status = 'warning'; // yellow
            } else {
                $status = 'danger'; // red
            }

            // Count project statuses
            $completedMilestones = $project->milestones()->wherePivot('completed', true)->count();
            if ($completedMilestones == 25) {
                $completedCount++;
            } else {
                $ongoingCount++;
                if ($status == 'danger') {
                    $overdueCount++;
                }
            }

            // Get officer in charge
            $oic = DB::table('project_team')
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

        // Calculate financial values
        $schemeValue = Project::sum('sv');
        $allocationValue = Project::sum('av');

        // Prepare sunburst chart data
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
            if(!empty($ministryNode['children'])) {
                $sunburstChildren[] = $ministryNode;
            }
        }

        $sunburstData = [
            'name' => 'flare',
            'children' => $sunburstChildren
        ];

        // Prepare donut chart data
        $projects = Project::with('milestones.status')->get();
        $stageCounts = [];
        foreach($projects as $project) {
            $milestone = $project->milestone;
            $statusName = $milestone && $milestone->status ? $milestone->status->name : 'Unknown';
            if(!isset($stageCounts[$statusName])) {
                $stageCounts[$statusName] = 0;
            }
            $stageCounts[$statusName]++;
        }

        $stageLabels = array_keys($stageCounts);
        $stageData = array_values($stageCounts);

        return view('dashboard', compact(
            'totalProjects',
            'completedCount',
            'ongoingCount',
            'overdueCount',
            'schemeValue',
            'allocationValue',
            'sunburstData',
            'stageLabels',
            'stageData',
            'projectNames',
            'physicalProgress',
            'financialProgress',
            'upcomingDeadlines'
        ));
    }

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
        if(session('roles') == 1){
            return view('pages.admin.project-dashboard', ['pageSlug' => 'project-dashboard']);
        } else if(session('roles') == 2){
            return view('pages.project_manager.project-dashboard', ['pageSlug' => 'project-dashboard']);
        } else if(session('roles') == 3){
            return view('pages.executive.project-dashboard', ['pageSlug' => 'project-dashboard']);
        }

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
     * Display contractor management page for admins
     */
    public function manageContractors() {
        $contractors = Contractor::all();

        return view('pages.admin.contractor', compact('contractors'));
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
        $projects = Project::all();
        if(session('roles') == 1){
            return view('pages.admin.projectsList', compact('projects'));
        } else if(session('roles') == 2){
            return view('pages.project_manager.projectsList', compact('projects'));
        } else if(session('roles') == 3){
            return view('pages.executive.projectsList', compact('projects'));
        }
        return redirect()->route('home');
    }
}
