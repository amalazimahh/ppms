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
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if(session('roles') == 1){
            // calculate the upcoming deadlines of projects
            $projects = Project::with('milestone.status')->get();

            $totalProjects = Project::count();
            $upcomingDeadlines = [];
            $completedCount = $ongoingCount = $overdueCount = 0;
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
                } elseif($diffInMonths > 0 && $diffInMonths <= 2){
                    $status = 'warning'; // yellow
                } else if($diffInMonths < 1){
                    $status = 'danger'; // red
                } else {
                    $status = 'success'; // green
                }


                // milestone logic
                $completedMilestones = $project->milestones
                    ->filter(function ($milestone) {
                        return $milestone->status && $milestone->status->name === 'Post-Completion';
                    })->count();

                $milestone = $project->milestone;
                $statusName = $milestone && $milestone->status ? $milestone->status->name : null;

                if ($statusName === 'Post-Completion') {
                    $completedCount++;
                } else {
                    $ongoingCount++;
                    if ($status === 'danger') {
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
                        ];
                    }

                    // add children
                    foreach ($projectsByParent[$parentProject->id] ?? [] as $childProject) {
                        $parentNode['children'][] = [
                            'name' => $childProject->title,
                            'value' => 1000
                        ];
                    }

                    // if no children, add a value to the parent node
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

            return view('pages.admin.dashboard', compact(
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
        } else if(session('roles') == 2){
            $user = Auth::user();

            $projects = Project::whereHas('projectTeam', function($query) use ($user) {
                $query->where('officer_in_charge', $user->id);
            })->with(['rkn', 'milestone.status', 'physical_status', 'financial_status'])->get();

            $ministries = ClientMinistry::whereHas('projects', function($query) use ($user) {
                $query->whereHas('projectTeam', function($q) use ($user) {
                        $q->where('officer_in_charge', $user->id);
                });
                })->with(['projects' => function($query) use ($user) {
                    $query->whereHas('projectTeam', function($q) use ($user) {
                        $q->where('officer_in_charge', $user->id);
                    });
            }])->get();

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

            $totalProjects = $projects->count();
            $upcomingDeadlines = [];
            $completedCount = 0;
            $ongoingCount = 0;
            $overdueCount = 0;

            $projectNames = [];
            $physicalProgress = [];
            $financialProgress = [];

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
                } elseif($diffInMonths > 0 && $diffInMonths <= 2){
                    $status = 'warning'; // yellow
                } else if($diffInMonths < 1){
                    $status = 'danger'; // red
                } else {
                    $status = 'success'; // green
                }

                // milestone logic
                $completedMilestones = $project->milestones
                    ->filter(function ($milestone) {
                        return $milestone->status && $milestone->status->name === 'Post-Completion';
                    })->count();

                $milestone = $project->milestone;
                $statusName = $milestone && $milestone->status ? $milestone->status->name : null;

                if ($statusName === 'Post-Completion') {
                    $completedCount++;
                } else {
                    $ongoingCount++;
                    if ($status === 'danger') {
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
            $schemeValue = $projects->sum('sv');
            $allocationValue = $projects->sum('av');

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

                    // add children
                    foreach ($projectsByParent[$parentProject->id] ?? [] as $childProject) {
                        $parentNode['children'][] = [
                            'name' => $childProject->title,
                            'value' => 1000
                        ];
                    }

                    // if no children, add a value to the parent node
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

                    return view('pages.project_manager.dashboard', compact(
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
        } else if(session('roles') == 3){
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
                $projectNames[] = $project->title;
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
                $completedMilestones = $project->milestones
                    ->filter(function ($milestone) {
                        return $milestone->status && $milestone->status->name === 'Post-Completion';
                    })->count();

                $milestone = $project->milestone;
                $statusName = $milestone && $milestone->status ? $milestone->status->name : null;

                if ($statusName === 'Post-Completion') {
                    $completedCount++;
                } else {
                    $ongoingCount++;
                    if ($status === 'danger') {
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

                    // add children
                    foreach ($projectsByParent[$parentProject->id] ?? [] as $childProject) {
                        $parentNode['children'][] = [
                            'name' => $childProject->title,
                            'value' => 1000
                        ];
                    }

                    // if no children, add a value to the parent node
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

            return view('pages.executive.dashboard', compact(
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
        else {
            return view('pages.dashboard');
        }
    }

}
