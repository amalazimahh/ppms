<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

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

    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = $user->roles_id ?? session('roles');
        $project = null;
        $progress = 0;
        $stages = [];
        $projectUpdates = collect();

        // check user role
        if (session('roles') == 2) {
            // only their projects
            $projects = Project::whereHas('projectTeam', function($q) use ($user) {
                $q->where('officer_in_charge', $user->id);
            })
            ->with([
                'physical_status',
                'financial_status',
                'milestones.status',
                'rkn',
                'milestone',
                'projectTeam.officerInCharge'
            ])
            ->get();
        } else {
            // admin or executive: show all projects
            $projects = Project::with([
                'physical_status',
                'financial_status',
                'milestones.status',
                'rkn',
                'milestone',
                'projectTeam.officerInCharge'
            ])
            ->get();
        }

        // if a project is selected, load its dashboard
        if ($request->has('project_id')) {
            $project = $projects->where('id', $request->project_id)->first();

            if ($project) {
                $projectUpdates = Notification::where('message', 'LIKE', '%' . $project->title . '%')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

                $totalMilestones = $project->milestones->unique('id')->count();
                $completedMilestones = $project->milestones->where('pivot.completed', true)->unique('id')->count();
                $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

                $allStatuses = Status::orderBy('id')->get();
                foreach ($allStatuses as $status) {
                    $stages[$status->id] = [
                        'name' => $status->name,
                        'completed' => false,
                        'current' => false,
                        'progress' => 0
                    ];
                }

                $currentStageFound = false;
                foreach ($stages as $statusId => &$stage) {
                    $stageMilestones = $project->milestones->where('statuses_id', $statusId);
                    $totalStageMilestones = $stageMilestones->unique('id')->count();
                    $completedStageMilestones = $stageMilestones->where('pivot.completed', true)->unique('id')->count();

                    if ($totalStageMilestones > 0) {
                        $stageProgress = round(($completedStageMilestones / $totalStageMilestones) * 100);
                        $stage['progress'] = $stageProgress;

                        if ($stageProgress == 100) {
                            $stage['completed'] = true;
                        } elseif (!$currentStageFound) {
                            $stage['current'] = true;
                            $currentStageFound = true;
                        }
                    }
                }
            }
        }

        if (session('roles') == 1) {
            return view('pages.admin.project-dashboard', compact('projects', 'project', 'progress', 'stages', 'projectUpdates'));
        } else if (session('roles') == 2) {
            return view('pages.project_manager.project-dashboard', compact('projects', 'project', 'progress', 'stages', 'projectUpdates'));
        } else if (session('roles') == 3) {
            return view('pages.executive.project-dashboard', compact('projects', 'project', 'progress', 'stages', 'projectUpdates'));
        }
    }
}
