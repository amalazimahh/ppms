<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Architect;
use App\Models\MechanicalElectrical;
use App\Models\CivilStructural;
use App\Models\QuantitySurveyor;

class ProjectTeamController extends Controller
{
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

    public function edit($id){
        $project = Project::findOrFail($id);
        $projectTeam = $project->projectTeam ?? new ProjectTeam();
        return view('pages.admin.forms.project_team', compact('project', 'projectTeam'));
    }

    public function update(Request $request, $id)
    {
        // Correct logging of request data
        Log::info('ProjectTeam Request Data:', ['data' => $request->all()]);
        $project = Project::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'officer_in_charge' => 'nullable|exists:users,id',
            'architect_id' => 'nullable|exists:architect,id',
            'mechanical_electrical_id' => 'nullable|exists:mechanical_electrical,id',
            'civil_structural_id' => 'nullable|exists:civil_structural,id',
            'quantity_surveyor_id' => 'nullable|exists:quantity_surveyor,id',
            'others_id' => 'nullable|string'
        ]);

        try {
            $projectTeam = ProjectTeam::updateOrCreate(
                ['project_id' => $id],
                $validated
            );

            Log::info('ProjectTeam Updated successfully', [
                'project_team' => $projectTeam->toArray(),
                'changes' => $projectTeam->getChanges()
            ]);

            $message = Str::limit($project->title . ' project team details have been updated.', 250);
            sendNotification('update_project_details', $message, ['Admin', 'Project Manager']);

            return redirect()->route('projects.project_team', $project->id)
                ->with('success', 'Project team details updated successfully!');
        } catch (\Exception $e) {
            Log::error('ProjectTeam Update failed', [
                'error' => $e->getMessage(),
                'project_id' => $id,
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update project team details. Please try again.');
        }
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
