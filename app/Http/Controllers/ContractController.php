<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contract;
use App\Models\Contractor;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    // show contract form
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $contract = $project->contract ?? new Contract();
        $contractors = Contractor::all();

        $milestones = $project->milestones;
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? ($completedMilestones / $totalMilestones) * 100 : 0;

        return view('pages.admin.forms.contract', compact('project', 'contract', 'contractors', 'milestones', 'progress'));
    }

    // update contract form details
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // validate input
        $validated = $request->validate([
            'contractor_id' => 'nullable|integer|exists:contractor,id',
            'contractNum' => 'nullable|string',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'period' => 'nullable|string',
            'sum' => 'nullable|string',
            'revSum' => 'nullable|string',
            'lad' => 'nullable|string',
            'totalLad' => 'nullable|string',
            'cnc' => 'nullable|date',
            'revComp' => 'nullable|date',
            'actualComp' => 'nullable|date',
            'cpc' => 'nullable|date',
            'edlp' => 'nullable|date',
            'cmgd' => 'nullable|date',
            'lsk' => 'nullable|date',
            'penAmt' => 'nullable|string',
            'retAmt' => 'nullable|string',
            'statDec' => 'nullable|date'
        ]);
    
        // Clean currency fields
        foreach (['sum', 'revSum', 'lad', 'totalLad', 'penAmt', 'retAmt'] as $field) {
            if (isset($validated[$field])) {
                // Remove everything except numbers and decimal point
                $validated[$field] = preg_replace('/[^\d.]/', '', $validated[$field]);
                // If the result is empty, set to null
                if ($validated[$field] === '') {
                    $validated[$field] = null;
                }
            }
        }
    
        $validated['project_id'] = $project->id;
    
        try {
            $contract = Contract::updateOrCreate(
                ['project_id' => $project->id],
                $validated
            );
    
            return redirect()->route('projects.contract', $project->id)
                ->with('success', 'Contract details have been updated.');
        } catch (\Exception $e) {
            Log::error('Contract update failed: ', [
                'error' => $e->getMessage(),
                'project_id' => $project->id,
                'input' => $validated
            ]);
    
            return back()->with('error', 'Failed to update contract details. Please try again.');
        }
    }
}
