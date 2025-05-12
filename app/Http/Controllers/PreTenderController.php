<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreTender;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PreTenderController extends Controller
{
    // show pre_tender edit form
    public function edit($id){
        $project = Project::findOrFail($id);
        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;
        $preTender = $project->preTender ?? new PreTender();
        return view('pages.admin.forms.pre_tender', compact('project', 'preTender', 'progress'));
    }

    public function update(Request $request, $id)
    {
        // Correct logging of request data
        Log::info('PreTender Request Data:', ['data' => $request->all()]);

        $project = Project::findOrFail($id);
        Log::info('Before Update:', $project->toArray());

        // Validate input
        $validated = $request->validate([
            'rfpRfqNum' => 'nullable|string|max:100',
            'rfqTitle' => 'nullable|string|max:255',
            'rfqFee' => 'nullable|string',
            'opened' => 'nullable|date',
            'closed' => 'nullable|date|after_or_equal:opened',
            'ext' => 'nullable|date|after_or_equal:closed',
            'validity_ext' => 'nullable|date|after_or_equal:ext',
            'jkmkkp_recomm' => 'nullable|date',
            'jkmkkp_approval' => 'nullable|date|after_or_equal:jkmkkp_recomm',
            'loa' => 'nullable|date',
            'aac' => 'nullable|date',
            'soilInv' => 'nullable|date',
            'topoSurvey' => 'nullable|date'
        ]);

        // Clean and convert empty fee to NULL
        if (isset($validated['rfqFee']) && $validated['rfqFee'] !== '') {
            $validated['rfqFee'] = preg_replace('/[^\d.]/', '', $validated['rfqFee']);
        } else {
            $validated['rfqFee'] = null;
        }

        Log::info('Cleaned rfqFee', ['value' => $validated['rfqFee']]);

        $project = Project::findOrFail($id);

        // Correct logging of existing data
        Log::info('Before PreTender Update:', [
            'project' => $project->toArray(),
            'pre_tender' => $project->preTender ? $project->preTender->toArray() : null
        ]);

        try {
            $preTender = PreTender::updateOrCreate(
                ['project_id' => $id],
                $validated
            );

            // Correct success logging
            Log::info('PreTender Updated successfully', [
                'pre_tender' => $preTender->toArray(),
                'changes' => $preTender->getChanges()
            ]);

            $message = Str::limit($project->title . ' pre-tender details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.pre_tender', $project->id)
                ->with('success', 'Pre-tender details updated successfully!');

        } catch (\Exception $e) {
            // Correct error logging
            Log::error('PreTender Update failed', [
                'error' => $e->getMessage(),
                'project_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update pre-tender details. Please try again.');
        }
    }
}
