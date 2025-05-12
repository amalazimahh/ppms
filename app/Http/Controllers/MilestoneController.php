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
        // retrieve project and its milestones
        $project = Project::with(['milestones'])->findOrFail($id);

        // retrieve all statuses with their milestones
        $statuses = Status::with('milestones')->get();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        return view('pages.admin.forms.status', compact('project', 'statuses', 'milestones', 'progress'));
    }
}
