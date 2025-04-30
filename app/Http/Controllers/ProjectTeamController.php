<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectTeamController extends Controller
{
    public function manageProjectTeam()
    {
    //
    }

    public function edit($id){
        $project = Project::findOrFail($id);
        $projectTeam = $project->projectTeam ?? new ProjectTeam();
        return view('pages.admin.forms.project_team', compact('project', 'projectTeam'));
    }

    public function update(Request $request, $id)
    {
        // Correct logging of request data
        Log::info('ProjectTeam Request Data:', ['data' => $request->all()]);
        $project = Project::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'officer_in_charge' => 'nullable|exists:users,id',
            'architect_id' => 'nullable|exists:architect,id',
            'mechanical_electrical_id' => 'nullable|exists:mechanical_electrical,id',
            'civil_structural_id' => 'nullable|exists:civil_structural,id',
            'quantity_surveyor_id' => 'nullable|exists:quantity_surveyor,id',
            'others_id' => 'nullable|string'
        ]);

        try {
            $projectTeam = ProjectTeam::updateOrCreate(
                ['project_id' => $id],
                $validated
            );

            Log::info('ProjectTeam Updated successfully', [
                'project_team' => $projectTeam->toArray(),
                'changes' => $projectTeam->getChanges()
            ]);

            $message = Str::limit($project->title . ' project team details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.project_team', $project->id)
                ->with('success', 'Project team details updated successfully!');
        } catch (\Exception $e) {
            Log::error('ProjectTeam Update failed', [
                'error' => $e->getMessage(),
                'project_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update project team details. Please try again.');
        }
    }
}
