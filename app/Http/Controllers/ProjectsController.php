<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Project;
use App\Models\Notification;
use App\Models\Status;
use App\Models\ClientMinistry;
use App\Models\Contractor;
use App\Models\Architect;
use App\Models\MechanicalElectrical;
use App\Models\CivilStructural;
use App\Models\QuantitySurveyor;
use App\Models\ProjectTeam;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{

    public function index()
    {
        $projects = Project::all();
        return view('pages.admin.projectsList', compact('projects'));
    }

    public function basicdetails()
    {
        // retrieve list of statuses
        $statuses = Status::all();

        // retrieve lists of clientMinistry
        $clientMinistries = ClientMinistry::all();

        // retrieve lists of project managers
        $projectManagers = User::where('roles_id', 2)->get();

        // retrieve lists of main contractors
        $contractors = Contractor::all();

        // retrieve lists of architect
        $architects = Architect::all();

        // retrieve lists of mechanical electrical
        $mechanicalElectricals = MechanicalElectrical::all();

        // retrieve lists of civil structural
        $civilStructurals = CivilStructural::all();

        // retrieve lists of quantity surveyor
        $quantitySurveyors = QuantitySurveyor::all();

        // check if user is Pm
        if(auth()->user()->roles_id == 2)
        {
            return view('pages.project_manager.forms.basicdetails', compact('statuses', 'projectManagers'));
        }

        // default to Admin view
        return view('pages.admin.forms.basicdetails',
            compact('statuses', 'clientMinistries', 'projectManagers', 'contractors',
                    'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors'));
    }

    // retrieve project details and pass them to the basic details form
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        // retrieve list of statuses
        $statuses = Status::all();

        // retrieve lists of clientMinistry
        $clientMinistries = ClientMinistry::all();

        // retrieve lists of project managers
        $projectManagers = User::where('roles_id', 2)->get();

        // retrieve lists of main contractors
        $contractors = Contractor::all();

        // retrieve lists of architect
        $architects = Architect::all();

        // retrieve lists of mechanical electrical
        $mechanicalElectricals = MechanicalElectrical::all();

        // retrieve lists of civil structural
        $civilStructurals = CivilStructural::all();

        // retrieve lists of quantity surveyor
        $quantitySurveyors = QuantitySurveyor::all();

        // default to Admin view
        return view('pages.admin.forms.basicdetails', compact(
            'project',
            'statuses',
            'clientMinistries',
            'projectManagers',
            'contractors',
            'architects',
            'mechanicalElectricals',
            'civilStructurals',
            'quantitySurveyors'
        ));
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        if($project){
            $project->delete();
            return redirect()->route('pages.admin.projectsList')->with('success', 'Project deleted successfully.');
        }
        return redirect()->route('pages.admin.projectsList')->with('error', 'Project not found.');
    }


    // add  pre_tender method to handle form
    public function pre_tender($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        return view('pages.admin.forms.pre_tender', compact('project'));
    }

    // add designSubmission method to handle form
    public function designSubmission($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        return view('pages.admin.forms.design_submission', compact('project'));
    }

    // add tender method to handle form
    public function tender($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        return view('pages.admin.forms.tender', compact('project'));
    }

    // add contract method to handle form
    public function contract($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        return view('pages.admin.forms.contract', compact('project'));
    }

    // store basicdetails form
    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());

        // validate input
        $request->validate([
            'fy' => 'required|string',
            'sv' => 'required|string',
            'av' => 'required|string',
            'statuses_id' => 'required|integer',
            'voteNum' => 'required|string',
            'title' => 'required|string',
            'oic' => 'required|integer',
            'client_ministry_id' => 'required|integer',
            'contractor_id' => 'required|integer',
            'contractorNum' => 'required|string',
            'siteGazette' => 'nullable|string',
            'soilInv' => 'nullable|date',
            'topoSurvey' => 'nullable|date',
            'handover' => 'nullable|date',
            'scope' => 'nullable|string',
            'location' => 'nullable|string',
            'architect_id' => 'nullable|integer',
            'mechanical_electrical_id' => 'nullable|integer',
            'civil_structural_id' => 'nullable|integer',
            'quantity_surveyor_id' => 'nullable|integer',
            'others_id' => 'nullable|string',
        ]);

        // Clean up the sv and av fields (remove dollar signs and commas)
        $sv = preg_replace('/[^\d.]/', '', $request->input('sv'));
        $av = preg_replace('/[^\d.]/', '', $request->input('av'));

        // Log to verify cleaned values
        Log::info('Cleaned sv: ' . $sv);
        Log::info('Cleaned av: ' . $av);

        // Log to see if the file is present in the request
        if ($request->hasFile('img')) {
            Log::info('File Uploaded: ' . $request->file('img')->getClientOriginalName());
            $imgPath = $request->file('img')->store('images', 'public');
            Log::info('Image path: ' . $imgPath);
        } else {
            Log::info('No file uploaded');
            $imgPath = null;
        }

        // get the last customID
        $lastProject = Project::latest('id')->first();
        // $newCustomID = 'P'.sprintf('%03d', ($lastProject ? substr($lastProject->customID, 1) : 0) + 1);

        // create default project team entry if it doesn't exist
        // $projectTeam = ProjectTeam::updateOrCreate(
        //     ['id' => $request->project_team_id],
        //     [
        //     'architect_id' => $request->architect,
        //     'mechanical_electrical_id' => $request->me,
        //     'civil_structural_id' => $request->cs,
        //     'quantity_surveyor_id' => $request->qs,
        //     'others_id' => $request->others,
        //     ]
        // );

        $projectTeam = null;

        // Create a new Project Team if at least one role is filled
        $projectTeam = ProjectTeam::create([
                'architect_id' => $request['architect_id'] ?? null,
                'mechanical_electrical_id' => $request['mechanical_electrical_id'] ?? null,
                'civil_structural_id' => $request['civil_structural_id'] ?? null,
                'quantity_surveyor_id' => $request['quantity_surveyor_id'] ?? null,
                'others_id' => $request['others_id'] ?? null,
        ]);

        //$created_by = (auth()->check()) ? (int)auth()->user()->id : null;

        // create a new Project
        $project = Project::create([
            'fy' => $request['fy'],
            'sv' => $sv,
            'av' => $av,
            'statuses_id' => $request['statuses_id'],
            'voteNum' => $request['voteNum'],
            'title' => $request['title'],
            'oic' => $request['oic'], // Project Manager
            'client_ministry_id' => $request['client_ministry_id'],
            'contractor_id' => $request['contractor_id'],
            'contractorNum' => $request['contractorNum'],
            'siteGazette' => $request['siteGazette'],
            'soilInv' => $request['soilInv'],
            'topoSurvey' => $request['topoSurvey'],
            'handover' => $request['handover'],
            'scope' => $request['scope'],
            'location' => $request['location'],
            'project_team_id' => $projectTeam->id,
            //'created_by' -> $created_by,
        ]);


        // Update project with project_team_id
        $project->update(['project_team_id' => $projectTeam->id]);

        // Log to confirm insertion
        Log::info('Project created: ', $project->toArray());
        $message = Str::limit('A new project ' . $project->title . ' has been added.', 250);

        // insert notification for the admin
        Notification::create([
            'user_id' => 1,
            'type' => 'new_project',
            'message' => $message,
            'read' => false
        ]);

        // redirect with success notification
        return redirect()->route('pages.admin.projectsList')->with('success', 'Project added successfully!');
    }


    public function markAsRead()
    {
        \App\Models\Notification::where('read', 0)->update(['read' => 1]);
        return response()->json(['message' => 'Notifications marked as read.']);
    }

    // handle project update basic details form
    public function update(Request $request, $id)
    {
        Log::info('Request Data:', $request->all());

        // Validate input
        $request->validate([
            'fy' => 'required|string',
            'sv' => 'required|string',
            'av' => 'required|string',
            'statuses_id' => 'required|integer',
            'voteNum' => 'required|string',
            'title' => 'required|string',
            'oic' => 'required|integer',
            'client_ministry_id' => 'required|integer',
            'contractor_id' => 'required|integer',
            'contractorNum' => 'required|string',
            'siteGazette' => 'nullable|string',
            'soilInv' => 'nullable|date',
            'topoSurvey' => 'nullable|date',
            'handover' => 'nullable|date',
            'scope' => 'nullable|string',
            'location' => 'nullable|string',
            'architect_id' => 'nullable|integer',
            'mechanical_electrical_id' => 'nullable|integer',
            'civil_structural_id' => 'nullable|integer',
            'quantity_surveyor_id' => 'nullable|integer',
            'others_id' => 'nullable|string',
        ]);

        // Clean up the sv and av fields (remove dollar signs and commas)
        $sv = preg_replace('/[^\d.]/', '', $request->input('sv'));
        $av = preg_replace('/[^\d.]/', '', $request->input('av'));

        // Log cleaned values
        Log::info('Cleaned sv: ' . $sv);
        Log::info('Cleaned av: ' . $av);

        $project = Project::findOrFail($id);
        Log::info('Before Update:', $project->toArray());

        // Find the existing project team or create a new one
        $projectTeam = ProjectTeam::find($project->project_team_id);

        if (!$projectTeam) {
            // create team if no project team exists
            Log::info('Creating a new project team.');
            $projectTeam = new ProjectTeam();
        } else {
            // debug existing project team ID
            Log::info('Updating existing Project Team ID: ' . $projectTeam->id);
        }

        // log current state of ProjectTeam before updating
        Log::info('ProjectTeam Before Update: ', $projectTeam->toArray());

        // update project team fields
        $projectTeam->architect_id = $request->architect_id ?? null;
        $projectTeam->mechanical_electrical_id = $request->mechanical_electrical_id ?? null;
        $projectTeam->civil_structural_id = $request->civil_structural_id ?? null;
        $projectTeam->quantity_surveyor_id = $request->quantity_surveyor_id ?? null;
        $projectTeam->others_id = $request->others_id ?? null;

        // log updated ProjectTeam fields
        Log::info('Updated ProjectTeam Fields: ', $projectTeam->toArray());

        // save the project team
        $projectTeam->save();

        // update the project with the new project_team_id
        $updated = $project->update([
            'fy' => $request['fy'],
            'sv' => $sv,
            'av' => $av,
            'statuses_id' => $request['statuses_id'],
            'voteNum' => $request['voteNum'],
            'title' => $request['title'],
            'oic' => $request['oic'], // Project Manager
            'client_ministry_id' => $request['client_ministry_id'],
            'contractor_id' => $request['contractor_id'],
            'contractorNum' => $request['contractorNum'],
            'siteGazette' => $request['siteGazette'],
            'soilInv' => $request['soilInv'],
            'topoSurvey' => $request['topoSurvey'],
            'handover' => $request['handover'],
            'scope' => $request['scope'],
            'location' => $request['location'],
            'project_team_id' => $projectTeam->id,
        ]);

        $message = Str::limit($project->title . ' has been modified.', 250);

        // insert notification for the admin
        Notification::create([
            'user_id' => 1,
            'type' => 'update_project_details',
            'message' => $message,
            'read' => false
        ]);

        // Log success or failure of project update
        if ($updated) {
            Log::info('Project Updated successfully', $project->toArray());
        } else {
            Log::info('Project Update failed: ', $project->toArray());
        }

        // Return the success response
        return redirect()->route('pages.admin.projectsList')->with('success', 'Project updated successfully!');
    }



}


?>
