<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use App\Models\Notification;
use App\Models\Status;
use App\Models\User;
use App\Models\ClientMinistry;
use App\Models\Contractor;
use App\Models\Architect;
use App\Models\MechanicalElectrical;
use App\Models\CivilStructural;
use App\Models\QuantitySurveyor;

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
        $statuses = Status::all();
        $projectManagers = User::where('roles_id', 2)->get();

        return view('pages.admin.forms.basicdetails', compact('project', 'statuses', 'projectManagers'));
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
        // validate input
        $request->validate([
            'fy' => 'required|string|max:255',
            'sv' => 'required|numeric',
            'av' => 'required|numeric',
            'statuses_id' => 'required|exists:statuses_id',
            'voteNum' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'oic' => 'required|numeric|exists:users,id',
            'client_ministry_id' => 'required|exists:client_ministry,id',
            'contractor_id' => 'required|exists:contractor,id',
            'contractorNum' => 'nullable|string|max:255',
            'siteGazette' => 'nullable|string|max:255',
            'soilInv' => 'nullable|date',
            'topoSurvey' => 'nullable|date',
            'handover' => 'nullable|date',
            'scope' => 'string|max:255',
            'location' => 'string|max:255',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_team_id' => 'nullable|exists:project_team,id',
        ]);

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
        $newCustomID = 'P'.sprintf('%03d', ($lastProject ? substr($lastProject->customID, 1) : 0) + 1);

        // create default project team entry if it doesn't exist
        $defaultProjectTeam = ProjectTeam::firstOrCreate([
            'architect_id' => null,
            'mechanical_electrical_id' => null,
            'civil_structural_id' => null,
            'quantity_surveyor_id' => null,
            'others_id' => null,
        ]);

        // create project in database
        $project = Project::create([
            'customID' => $newCustomID,
            'fy' => $request->input('fy'),
            'sv' => $request->input('sv'),
            'av' => $request->input('av'),
            'statuses_id' => $request->input('statuses_id'),
            'voteNum' => $request->input('voteNum'),
            'title' => $request->input('title'),
            'oic' => $request->input('oic'),
            'client_ministry_id' => $request->input('client_ministry_id'),
            'contractor_id' => $request->input('contractor_id'),
            'contractorNum' => $request->input('contractorNum'),
            'siteGazette' => $request->input('siteGazette'),
            'soilInv' => $request->input('soilInv'),
            'topoSurvey' => $request->input('topoSurvey'),
            'handover' => $request->input('handover'),
            'scope' => $request->input('scope'),
            'location' => $request->input('location'),
            'img' => $imgPath,
            'project_team_id' => $defaultProjectTeam->id,
            'created_by' => auth()->id(),
        ]);

        // insert notification for the admin
        Notification::create([
            'user_id' => 1,
            'message' => 'A new project <b>'.$project->title.'</b> has been added.',
            'read' => false
        ]);

        // redirect with success notification
        return redirect()->route('pages.admin.forms.basicdetails')->with('success', 'Project added successfully!');
    }

    public function markAsRead()
    {
        \App\Models\Notification::where('read', 0)->update(['read' => 1]);
        return response()->json(['message' => 'Notifications marked as read.']);
    }
}


?>
