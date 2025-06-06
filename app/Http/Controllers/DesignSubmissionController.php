<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\DesignSubmission;
use App\Models\Milestone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DesignSubmissionController extends Controller
{
    //show design submission form
    public function edit($id){
        $project = Project::findOrFail($id);
        $designSubmission = $project->designSubmission ?? new DesignSubmission();
        $milestones = $project->milestones;
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0? round(($completedMilestones / $totalMilestones) * 100) : 0;
        return view('pages.admin.forms.design_submission', compact('project', 'designSubmission', 'progress'));
    }

    // update design submission form details
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // validate input
        $validated = $request->validate([
            'kom' => 'nullable|date',
            'conAppr' => 'nullable|date',
            'designRev' => 'nullable|date',
            'detailedRev' => 'nullable|date',
        ]);

        try {
            $designSubmission = DesignSubmission::updateOrCreate(
                ['project_id' => $project->id],
                $validated
            );

            $message = Str::limit($project->title . ' design submission details have been updated.', 250);
            sendNotification('update_project_details', $message);

            return redirect()->route('projects.design_submission', $project->id)
                ->with('success', 'Design submission details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Design Submission Update Error: ', [
                'error' => $e->getMessage(),
                'project_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update design submission details. Please try again.');
        }
    }
}
