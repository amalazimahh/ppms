<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Status;

class ProjectMilestoneController extends Controller
{
    public function toggle(Request $request, Project $project, Milestone $milestone)
    {
        $completed = $request->input('completed') ? true : false;

        // This will insert or update the pivot row as needed
        $project->milestones()->syncWithoutDetaching([
            $milestone->id => [
                'completed' => $completed,
                'completed_at' => $completed ? now() : null,
            ]
        ]);

        // Find the latest completed milestone (assuming you have an 'order' or 'id' column for ordering)
        $latestCompleted = $project->milestones()
            ->wherePivot('completed', true)
            ->orderBy('milestones.id', 'desc') // or use your milestone order column if you have one
            ->first();

        // Update the project's milestone_id
        $project->milestones_id = $latestCompleted ? $latestCompleted->id : null;
        $project->save();

        return response()->json(['success' => true]);
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
