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
        $project = null;
        $progress = 0;
        $stages = [];
        $projectUpdates = collect();

        if($request->has('project_name')){
            $project = Project::where('title', 'LIKE', '%' . $request->project_name . '%')
                ->with([
                    'physical_status',
                    'financial_status',
                    'milestones.status',
                    'rkn',
                    'milestone',
                    'projectTeam.officerInCharge'
                ])
                ->first();

            if($project) {
                // retrieve project-related notifications with pagination
                $projectUpdates = Notification::where('message', 'LIKE', '%' . $project->title . '%')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

                // calculate overall progress (progress bar)
                $totalMilestones = $project->milestones->unique('id')->count();
                $completedMilestones = $project->milestones->where('pivot.completed', true)->unique('id')->count();
                $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

                // get all statuses in order by ID
                $allStatuses = Status::orderBy('id')->get();

                // store stages array with default values
                foreach ($allStatuses as $status) {
                    $stages[$status->id] = [
                        'name' => $status->name,
                        'completed' => false,
                        'current' => false,
                        'progress' => 0
                    ];
                }

                // calculate progress for each stage
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

                \Log::info('Stages data:', ['stages' => $stages]);
            }
        }

        if(session('roles') == 1) {
            return view('pages.admin.project-dashboard', compact('project', 'progress', 'stages', 'projectUpdates'));
        } elseif(session('roles') == 2) {
            return view('pages.project_manager.project-dashboard', compact('project', 'progress', 'stages', 'projectUpdates'));
        }

        return redirect()->route('home');
    }
}
