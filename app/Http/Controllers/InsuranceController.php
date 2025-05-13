<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contract;
use App\Models\Insurance;
use App\Models\InsuranceType;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InsuranceController extends Controller
{
    // show insurance form
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $insurance = Insurance::where('contract_id', $id)->first();
        $insuranceType = InsuranceType::all();

        // get related project via contract
        $project = $contract->project;

        // get milestones from project
        $milestones = $project ? $project->milestones:collect();
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;

        return view('pages.admin.forms.insurance', compact('project', 'contract', 'insurance', 'insuranceType', 'milestones', 'progress'));
    }

    // update/create insurance form function
    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        // validate insurance form input
        $validated = $request->validate([
            'insType' => 'nullable|string',
            'insIssued' => 'nullable|date',
            'insExpiry' => 'nullable|date',
            'insExt' => 'nullable|date'
        ]);

        try {
            $insurance = Insurance::updateOrCreate(
                ['contract_id' => $id],
                $validated
            );

            $message = Str::limit($contract-> title . ' insurance form details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.insurance', $contract->id)
                ->with('success', 'Insurance form details have been updated.');
        } catch (\Exception $e) {
            Log::error('Insurance update failed: ', [
                'error' => $e->getMessage(),
                'contract_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update insurance form details. Please try again.');
        }
    }
}
