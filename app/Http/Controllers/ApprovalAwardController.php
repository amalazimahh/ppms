<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Tender;
use App\Models\TenderRecommendation;
use App\Models\ApprovalAward;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApprovalAwardController extends Controller
{
    // show approval of award form
    public function edit($id)
    {
        $tender = Tender::where('project_id', $id)->first();
        $award = $tender ? TenderRecommendation::where('tender_id', $tender->id)->first() : null;

        // get related project via tender
        $project = $tender ? $tender->project : Project::findOrFail($id);

        // get milestones from project
        $milestones = $project ? $project->milestones:collect();
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;

        return view('pages.admin.forms.approval_award', compact('project', 'tender', 'award', 'milestones', 'progress'));
    }

    // update approval of award
    public function update(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        // validate approval of award form input
        $validated = $request->validate([
            'loaIssued' => 'nullable|date',
            'loa' => 'nullable|date',
            'ladDay' => 'nullable|date',
            'docPrep' => 'nullable|date',
            'conSigned' => 'nullable|date',
        ]);

        try {
            $award = ApprovalAward::updateOrCreate(
                ['tender_id' => $id],
                $validated
            );

            $message = Str::limit($tender->title . ' approval of award details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.approval_award', $tender->id)
                ->with('success', 'Approval of Award details have been updated.');
        } catch (\Exception $e) {
            Log::error('Tender Recommendation update failed: ', [
                'error' => $e->getMessage(),
                'tender_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update Approval of Award details. Please try again.');
        }
    }
}
