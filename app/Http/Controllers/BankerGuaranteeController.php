<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contract;
use App\Models\BankerGuarantee;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BankerGuaranteeController extends Controller
{
    // show banker guarantee form
    public function edit($id)
    {
        $contract = Contract::where('project_id', $id)->first();
        $bankerGuarantee = $contract ? BankerGuarantee::where('contract_id', $contract->id)->first() : null;

        // get related project via contract
        $project = $contract ? $contract->project : Project::findOrFail($id);

        // get milestones from project
        $milestones = $project ? $project->milestones:collect();
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;

        return view('pages.admin.forms.bankers_guarantee', compact('project', 'contract', 'bankerGuarantee', 'milestones', 'progress'));
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        // validate banker guarantee form input
        $validated = $request->validate([
            'bgAmt' => 'nullable|string',
            'bgIssued' => 'nullable|date',
            'bgExpiry' => 'nullable|date',
            'bgExt' => 'nullable|date'
        ]);

        $validated['bgAmt'] = preg_replace('/[^\d.]/', '', $request->input('bgAmt'));

        try {
            $bankerGuarantee = BankerGuarantee::updateOrCreate(
                ['contract_id' => $contract->id],
                $validated
            );

            $message = Str::limit($contract->title . ' banker guarantee details have been updated.', 250);
            sendNotification('update_project_details', $message);

            return redirect()->route('projects.bankers_guarantee', $contract->id)
                ->with('success', 'Banker guarantee details have been updated.');
        } catch(\Exception $e){
            Log::error('Banker Guarantee update failed: ', [
                'error' => $e->getMessage(),
                'contract_id' => $contract->id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update banker guarantee details. Please try again.');
        }
    }
}
