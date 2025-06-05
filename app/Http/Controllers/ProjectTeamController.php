<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Architect;
use App\Models\MechanicalElectrical;
use App\Models\CivilStructural;
use App\Models\QuantitySurveyor;
use App\Models\ProjectTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectTeamController extends Controller
{
    public function edit($id)
    {
        $user = auth()->user();
        $project = Project::with('projectTeam')->findOrFail($id);

        // Check if user is admin or the project manager in charge
        if (session('roles') != 1 && // not admin
            (!$project->projectTeam || // no project team
             $project->projectTeam->officer_in_charge != $user->id)) { // not the officer in charge
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // retrieve lists of project managers (oic)
        $projectManagers = User::where('roles_id', 2)->get();

        // retrieve lists of other team members
        $architects = Architect::all();
        $mechanicalElectricals = MechanicalElectrical::all();
        $civilStructurals = CivilStructural::all();
        $quantitySurveyors = QuantitySurveyor::all();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        // Return appropriate view based on role
        if (session('roles') == 1) {
            return view('pages.admin.forms.project_team', compact('project', 'projectManagers', 'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'progress'));
        } else {
            return view('pages.project_manager.forms.project_team', compact('project', 'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'progress'));
        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $project = Project::findOrFail($id);

        // Check if user is admin or the project manager in charge
        if (session('roles') != 1 && // not admin
            (!$project->projectTeam || // no project team
             $project->projectTeam->officer_in_charge != $user->id)) { // not the officer in charge
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // Validate input
        $validated = $request->validate([
            'officer_in_charge' => 'required|exists:users,id',
            'architect_id' => 'nullable|exists:architect,id',
            'mechanical_electrical_id' => 'nullable|exists:mechanical_electrical,id',
            'civil_structural_id' => 'nullable|exists:civil_structural,id',
            'quantity_surveyor_id' => 'nullable|exists:quantity_surveyor,id',
            'others_id' => 'nullable|string'
        ]);

        try {
            // For project managers, ensure they can't change the officer_in_charge
            if (session('roles') == 2) {
                $validated['officer_in_charge'] = $user->id;
            }

            $projectTeam = ProjectTeam::updateOrCreate(
                ['project_id' => $id],
                $validated
            );

            $message = Str::limit($project->title . ' project team details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.project_team', $project->id)
                ->with('success', 'Project team details updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update project team details. Please try again.');
        }
    }

    public function manageProjectTeam()
    {
        $architects = Architect::all();
        $civilEngineers = CivilStructural::all();
        $mechanicalElectricals = MechanicalElectrical::all();
        $quantitySurveyors = QuantitySurveyor::all();

        // format date created_at for each discipline (dd-mm-yyyy)
        foreach ($architects as $architect) {
            $architect->formatted_created_at = $architect->created_at ? $architect->created_at->format('d-m-Y') : 'N/A';
        }
        foreach ($civilEngineers as $ce) {
            $ce->formatted_created_at = $ce->created_at ? $ce->created_at->format('d-m-Y') : 'N/A';
        }
        foreach ($mechanicalElectricals as $me) {
            $me->formatted_created_at = $me->created_at ? $me->created_at->format('d-m-Y') : 'N/A';
        }
        foreach ($quantitySurveyors as $qs) {
            $qs->formatted_created_at = $qs->created_at ? $qs->created_at->format('d-m-Y') : 'N/A';
        }

        return view('pages.admin.project_team', compact('architects', 'civilEngineers', 'mechanicalElectricals', 'quantitySurveyors'));
    }

    public function addDiscipline(Request $request)
    {
        $discipline = $request->input('discipline');
        $fields = [];
        $rules = [];

        switch ($discipline) {
            case 'architects':
                $rules = [
                    'name' => 'required|string|max:255',
                ];
                $fields = $request->only(['name']);
                break;
            case 'civils':
                $rules = [
                    'name' => 'required|string|max:255',
                ];
                $fields = $request->only(['name']);
                break;
            case 'mechanicals':
                $rules = [
                    'name' => 'required|string|max:255',
                ];
                $fields = $request->only(['name']);
                break;
            case 'surveyors':
                $rules = [
                    'name' => 'required|string|max:255',
                ];
                $fields = $request->only(['name']);
                break;
            default:
                return back()->with('error', 'Invalid discipline type.');
        }

        $request->validate($rules);

        switch ($discipline) {
            case 'architects':
                Architect::create($fields);
                break;
            case 'civils':
                CivilStructural::create($fields);
                break;
            case 'mechanicals':
                MechanicalElectrical::create($fields);
                break;
            case 'surveyors':
                QuantitySurveyor::create($fields);
                break;
        }

        return back()->with('success', 'New discipline member added successfully!');
    }

    public function deleteDiscipline($discipline, $id)
    {
        switch ($discipline) {
            case 'architects':
                Architect::destroy($id);
                break;
            case 'civils':
                CivilStructural::destroy($id);
                break;
            case 'mechanicals':
                MechanicalElectrical::destroy($id);
                break;
            case 'surveyors':
                QuantitySurveyor::destroy($id);
                break;
            default:
                return back()->with('error', 'Invalid discipline type.');
        }
        return back()->with('success', 'Discipline member deleted successfully!');
    }
}
