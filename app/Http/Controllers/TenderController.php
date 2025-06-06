<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Tender;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    // show tender form
    public function edit($id){
        $project = Project::findOrFail($id);
        $tender = $project->tender ?? new Tender();

        $milestones = $project->milestones;
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;
        return view('pages.admin.forms.tender', compact('project', 'tender', 'milestones', 'progress'));
    }

    // update tender form details
    public function update(Request $request, $id)
    {
        $project = Project::findOrfail($id);

        // validate input
        $validated = $request->validate([
            'confirmFund' => 'nullable|date',
            'costAmt' => 'nullable|string',
            'costDate' => 'nullable|date',
            'tenderNum' => 'nullable|string',
            'openedFirst' => 'nullable|date',
            'openedSec' => 'nullable|date',
            'closed' => 'nullable|date',
            'ext' => 'nullable|date',
            'validity' => 'nullable|date',
            'validity_ext' => 'nullable|date',
            'cancelled' => 'nullable|date',
        ]);

         // remove dollar signs and commas for costAmt field (clean values)
         $costAmt = preg_replace('/[^\d.]/', '', $request->input('costAmt'));
         $validated['costAmt'] = $costAmt;

         try {
            $tender = Tender::updateOrCreate(
                ['project_id' => $project->id],
                $validated
            );

            $message = Str::limit($project->title . ' tender details have been updated.', 250);
            sendNotification('update_project_details', $message);

            return redirect()->route('projects.tender', $project->id)
                ->with('success', 'Tender details have been updated.');
         } catch (\Exception $e) {
             Log::error('Tender update failed: ', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
                'input' => $validated
             ]);

             return back()->with('error', 'Failed to update tender details. Please try again.');
         }
    }
}
