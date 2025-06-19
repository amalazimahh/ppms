<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Status;
use App\Models\Contractor;
use App\Models\ClientMinistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class PageController extends Controller
{

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications(Request $request)
    {
        $user = auth()->user();
    $role = session('roles');
    $type = $request->input('type');

    // Start with a base query joining notifications and notification_recipient
    $query = DB::table('notifications')
        ->join('notification_recipient', 'notifications.id', '=', 'notification_recipient.notification_id')
        ->orderBy('notifications.created_at', 'desc')
        ->select('notifications.*', 'notification_recipient.read', 'notification_recipient.user_id');

    // Filter by notification type if requested
    if ($type) {
        $query->where('notifications.type', $type);
    }

    if ($role == 1) {
        // Admin: see all notifications
        // No extra filter
    } elseif ($role == 2) {
        // Project Manager: only their projects, and only certain types
        $allowedTypes = [
            'upcoming_deadline',
             'update_project_details',
            'update_project_status',
            'overbudget',
            'overdue'
        ];
        $query->whereIn('notifications.type', $allowedTypes)
              ->where('notification_recipient.user_id', $user->id);
    } elseif ($role == 3) {
        // Executive: all projects, only certain types
        $allowedTypes = [
            'upcoming_deadline',
            'update_project_status',
            'overbudget',
            'overdue'
        ];
        $query->whereIn('notifications.type', $allowedTypes);
    }

    $notifications = $query->paginate(10);

    return view('pages.notification', compact('notifications'));
}


    /**
     * Display the dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // calculate the upcoming deadlines of projects
            $projects = Project::with('milestone.status')->get();

            $totalProjects = Project::count();
            $upcomingDeadlines = [];
            $completedCount = 0;
            $ongoingCount = 0;
            $overdueCount = 0;
            $ministries = ClientMinistry::with(['projects.physical_status', 'projects.financial_status'])->get();

            $projectsByMinistry = [];
            foreach ($ministries as $ministry) {
                $projectsByMinistry[$ministry->id] = $ministry->projects->map(function($project) {
                    return [
                        'title' => $project->title,
                        'physical' => $project->physical_status ? $project->physical_status->actual : 0,
                        'financial' => $project->financial_status ? $project->financial_status->actual : 0,
                    ];
                });
            }

            $mainProjects = Project::whereNull('parent_project_id')->get();

            $projectNames = [];
            $physicalProgress = [];
            $financialProgress = [];

            foreach($projects as $project){
                // project data for the progress chart
                if ($project->parent_project_id) {
                    $parentTitle = optional(\App\Models\Project::find($project->parent_project_id))->title;
                    $projectNames[] = $parentTitle ? "{$parentTitle} - {$project->title}" : $project->title;
                } else {
                    $projectNames[] = $project->title;
                }
                $physicalProgress[] = $project->physical_status ? $project->physical_status->actual : 0;
                $financialProgress[] = $project->financial_status ? $project->financial_status->actual : 0;

                // use endDate as the deadline
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

            // Sort by status: danger (red), warning (yellow), success (green)
            $statusOrder = ['danger' => 1, 'warning' => 2, 'success' => 3];
            usort($upcomingDeadlines, function($a, $b) use ($statusOrder) {
                return ($statusOrder[$a['status']] ?? 4) <=> ($statusOrder[$b['status']] ?? 4);
            });

            // Paginate (10 per page)
            $page = request()->get('page', 1);
            $perPage = 10;
            $offset = ($page - 1) * $perPage;
            $paginatedDeadlines = new LengthAwarePaginator(
                array_slice($upcomingDeadlines, $offset, $perPage),
                count($upcomingDeadlines),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

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

                // group projects by parent_project_id
                $projectsByParent = [];
                foreach ($ministry->projects as $project) {
                    $projectsByParent[$project->parent_project_id ?? 0][] = $project;
                }

                // add parent projects (parent_project_id == null)
                foreach ($projectsByParent[0] ?? [] as $parentProject) {
                    $parentNode = [
                        'name' => $parentProject->title,
                        'children' => []
                    ];

                    // add children (if any)
                    foreach ($projectsByParent[$parentProject->id] ?? [] as $childProject) {
                        $parentNode['children'][] = [
                            'name' => $childProject->title,
                            'value' => 1000 // or whatever value you want
                        ];
                    }

                    // if no children, you can add a value to the parent node itself
                    if (empty($parentNode['children'])) {
                        $parentNode['value'] = 1000;
                    }

                    $ministryNode['children'][] = $parentNode;
                }

                if (!empty($ministryNode['children'])) {
                    $sunburstChildren[] = $ministryNode;
                }
            }

            $sunburstData = [
                'name' => 'Ministries Projects',
                'children' => $sunburstChildren
            ];

            // group projects by milestone stage for donut chart
            $projects = Project::with('milestones.status')->get();
            $stageCounts = [];
            foreach($projects as $project){
                $milestone = $project->milestone;
                $statusName = $milestone && $milestone->status ? $milestone->status->name : 'Pre-Design';
                if(!isset($stageCounts[$statusName])){
                    $stageCounts[$statusName] = 0;
                }
                $stageCounts[$statusName]++;
            }

            $stageLabels = array_keys($stageCounts);
            $stageData = array_values($stageCounts);

        return view('dashboard', compact(
            'projects',
                'totalProjects',
                'paginatedDeadlines',
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
                'financialProgress',
                'projectsByMinistry'
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
