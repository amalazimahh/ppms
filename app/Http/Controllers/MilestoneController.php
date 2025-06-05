<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use App\Models\Status;
use App\Models\Milestone;
use Illuminate\Support\Str;


class MilestoneController extends Controller
{
    public function milestone($id)
    {
        $user = auth()->user();
        // retrieve project and its milestones
        $project = Project::with(['milestones', 'projectTeam.officerInCharge'])->findOrFail($id);

        // Check if user is admin or the project manager in charge
        if (session('roles') != 1 && // not admin
            (!$project->projectTeam || // no project team
             $project->projectTeam->officer_in_charge != $user->id)) { // not the officer in charge
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // retrieve all statuses with their milestones
        $statuses = Status::with('milestones')->get();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        // Return appropriate view based on role
        if (session('roles') == 1) {
            return view('pages.admin.forms.status', compact('project', 'statuses', 'milestones', 'progress'));
        } else {
            return view('pages.project_manager.forms.status', compact('project', 'statuses', 'milestones', 'progress'));
        }
    }
}
