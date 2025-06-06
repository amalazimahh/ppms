<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Status;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectMilestoneController extends Controller
{
    public function toggle(Project $project, Milestone $milestone)
    {
        try {
            // Get the current completion status
            $currentStatus = $project->milestones()
                ->where('milestone_id', $milestone->id)
                ->first()
                ->pivot
                ->completed;

            // Toggle the status
            $project->milestones()
                ->updateExistingPivot($milestone->id, ['completed' => !$currentStatus]);

            // Send notification about milestone change
            $message = Str::limit("Project {$project->title} has been updated to milestone: {$milestone->name}.", 250);
            sendNotification('update_project_status', $message);

            return response()->json([
                'success' => true,
                'message' => 'Milestone status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling milestone: ', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
                'milestone_id' => $milestone->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update milestone status'
            ], 500);
        }
    }

    public function getProgress(Project $project)
    {
        // retrieve project and its milestones
        $project->load('milestones');

        // retrieve all statuses with their milestones
        $statuses = Status::with('milestones')->get();

        // Get all milestones for the project
        $milestones = $project->milestones;

        // Calculate progress
        $totalMilestones = $milestones->unique('id')->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->unique('id')->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        \Log::info('Total Milestones: ' . $totalMilestones);
        \Log::info('Completed Milestones: ' . $completedMilestones);
        \Log::info('Calculated Progress: ' . $progress);

        return view('pages.admin.forms.status', compact('project', 'statuses', 'milestones', 'progress'));
    }
}
