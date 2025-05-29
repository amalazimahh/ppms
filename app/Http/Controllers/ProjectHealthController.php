<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PhysicalStatus;
use App\Models\FinancialStatus;
use App\Models\Milestone;

class ProjectHealthController extends Controller
{
    public function show($id) {
        $project = Project::findOrFail($id);
        $physical = $project->physical_status ?? new PhysicalStatus();
        $financial = $project->financial_status ?? new FinancialStatus();

         // get all milestones for the project
         $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        return view('pages.admin.forms.project_health', compact('project', 'physical', 'financial', 'milestones', 'progress'));
    }

    public function update(Request $request, $id) {
        $type = $request->input('type');
        $validated = $request->validate([
            'scheduled' => 'nullable|numeric|min:0|max:100',
            'actual' => 'nullable|numeric|min:0|max:100',
        ]);
        $project = Project::findOrFail($id);
        if ($type === 'physical') {
            $physical = $project->physical_status ?? new PhysicalStatus();
            $physical->project_id = $project->id;
            $physical->scheduled = $validated['scheduled'];
            $physical->actual = $validated['actual'];
            $physical->save();
            return redirect()->back()->with('success', 'Physical status updated!');
        } elseif ($type === 'financial') {
            $financial = $project->financial_status ?? new FinancialStatus();
            $financial->project_id = $project->id;
            $financial->scheduled = $validated['scheduled'];
            $financial->actual = $validated['actual'];
            $financial->save();
            return redirect()->back()->with('success', 'Financial status updated!');
        }
        return redirect()->back()->with('error', 'Invalid form type.');
    }
}
