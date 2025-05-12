<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Tender;
use App\Models\TenderRecommendation;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TenderRecommendationController extends Controller
{
    // show tender recommendation form
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        $recommendation = TenderRecommendation::where('tender_id', $id)->first();

        // get related project via tender
        $project = $tender->project;

        // get milestones from project
        $milestones = $project ? $project->milestones:collect();
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;

        return view('pages.admin.forms.tender_recommendation', compact('project', 'tender', 'recommendation', 'milestones', 'progress'));
    }

    public function update(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        // validate tender recommendation form input
        $validated = $request->validate([
            'toConsultant' => 'nullable|date',
            'fromConsultant' => 'nullable|date',
            'fromBPP' => 'nullable|date',
            'toDG' => 'nullable|date',
            'toLTK' => 'nullable|date',
            'ltkApproval' => 'nullable|date',
            'discLetter' => 'nullable|date'
        ]);

        try {
            $recommendation = TenderRecommendation::updateOrCreate(
                ['tender_id' => $tender->id],
                $validated
            );

            $message = Str::limit($tender->title . ' tender recommendation details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.tender_recommendation', $tender->id)
                ->with('success', 'Tender recommendation details have been updated.');
        } catch (\Exception $e) {
            Log::error('Tender Recommendation update failed: ', [
                'error' => $e->getMessage(),
                'tender_id' => $tender->id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update tender recommendation details. Please try again.');
        }
    }
}
