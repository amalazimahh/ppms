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
        $project = Project::with('status.milestones')->findOrFail($id);

        // Retrieve all statuses with their milestones
        $statuses = Status::with('milestones')->get();

        // Check if the project has a status
        if ($project->status) {
            // Get the milestones for the status
            $milestones = $project->status->milestones;
        } else {
            // No status assigned, so no milestones
            $milestones = collect(); // Empty collection
        }

        return view('pages.admin.forms.status', compact('project', 'statuses', 'milestones'));
    }
}
