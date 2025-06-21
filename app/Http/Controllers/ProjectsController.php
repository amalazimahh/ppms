<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\Status;
use App\Models\Milestone;
use App\Models\ClientMinistry;
use App\Models\Contractor;
use App\Models\Architect;
use App\Models\MechanicalElectrical;
use App\Models\CivilStructural;
use App\Models\QuantitySurveyor;
use App\Models\ProjectTeam;
use App\Models\RKN;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectsController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $projects = collect();
        $mainProjects = collect();
        $rkns = RKN::all();
        $statuses = Status::all();
        $clientMinistries = ClientMinistry::all();

        if (session('roles') == 1) {
            // admin retrieve all projects
            $projects = Project::with(['milestones', 'projectTeam.officerInCharge', 'rkn'])->get();
            $mainProjects = Project::whereNull('parent_project_id')->get();
            return view('pages.admin.projectsList', compact('projects', 'mainProjects', 'rkns', 'clientMinistries', 'statuses'));
        } elseif (session('roles') == 2) {
            // project manager retrieve only their projects (if they are the OIC)
            $projects = Project::whereHas('projectTeam', function($query) use ($user) {
                $query->where('officer_in_charge', $user->id);
            })->with(['milestones', 'projectTeam.officerInCharge', 'rkn'])->get();

            $mainProjects = Project::whereHas('projectTeam', function($query) use ($user) {
                $query->where('officer_in_charge', $user->id);
            })->whereNull('parent_project_id')->get();

            return view('pages.project_manager.projectsList', compact('projects', 'mainProjects', 'rkns'));
        } elseif (session('roles') == 3) {
            // admin retrieve all projects
            $projects = Project::with(['milestones', 'projectTeam.officerInCharge', 'rkn'])->get();
            $mainProjects = Project::whereNull('parent_project_id')->get();
            return view('pages.executive.projectsList', compact('projects', 'mainProjects', 'rkns', 'clientMinistries', 'statuses'));
        }
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $title = $request->input('title');
        $rknId = $request->input('rkn_id');
        $clientMinistryId = $request->input('client_ministry_id');
        $statusId = $request->input('statuses_id');

        $query = Project::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
        if ($rknId) {
            $query->where('rkn_id', $rknId);
        }
        if ($clientMinistryId) {
            $query->where('client_ministry_id', $clientMinistryId);
        }
        if ($statusId) {
            $query->whereHas('mainMilestone', function($q) use ($statusId) {
                $q->where('statuses_id', $statusId);
            });
        }

        if (session('roles') == 2) {
            $query->whereHas('projectTeam', function($q) use ($user) {
                $q->where('officer_in_charge', $user->id);
            });
        }

        $projects = $query->with(['mainMilestone.status', 'projectTeam.officerInCharge', 'rkn', 'parentProject'])->get();

        // Add calculated progress to each project
        $projects->transform(function ($project) {
            $milestones = $project->milestones;
            $total = $milestones->count();
            $completed = $milestones->where('pivot.completed', true)->count();
            $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
            $project->progress = $progress;
            return $project;
        });

        if ($request->ajax()) {
            return response()->json(['projects' => $projects]);
        }

        // Otherwise, return the normal view
        $mainProjects = Project::whereNull('parent_project_id')->get();
        $rkns = RKN::all();
        $clientMinistries = ClientMinistry::all();
        $statuses = Status::all();

        if(session('roles') == 1){
            return view('pages.admin.projectsList', compact('projects', 'mainProjects', 'rkns', 'clientMinistries', 'statuses'));
        } else if(session('roles') == 2){
            return view('pages.project_manager.projectsList', compact('projects', 'mainProjects', 'rkns', 'clientMinistries', 'statuses'));
        } else if(session('roles') == 3){
            return view('pages.executive.projectsList', compact('projects', 'mainProjects', 'rkns', 'clientMinistries', 'statuses'));
        }
        return redirect()->route('home')->with('error', 'Unauthorized access');

    }

    public function basicdetails($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        // retrieve lists of RKN
        $rkns = RKN::all();

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

        $mainProjects = Project::whereNull('parent_project_id')->get();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        // check if user is Pm
        if(session('roles') == 1)
        {
            return view('pages.admin.forms.basicdetails',
            compact('project', 'rkns', 'statuses', 'clientMinistries', 'projectManagers', 'contractors',
                    'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'mainProjects', 'progress'));
        } else if(session('roles') == 2)
        {
            return view('pages.project_manager.forms.basicdetails',
            compact('project', 'rkns', 'statuses', 'clientMinistries', 'projectManagers', 'contractors',
                    'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'mainProjects', 'progress'));
        } else if(session('roles') == 3)
        {
            return view('pages.project_manager.forms.basicdetails',
            compact('project', 'rkns', 'statuses', 'clientMinistries', 'projectManagers', 'contractors',
                    'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'mainProjects', 'progress'));
        }
    }

    // retrieve project details and pass to the basic details form
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        // retrieve lists of RKN
        $rkns = RKN::all();

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

        $mainProjects = Project::whereNull('parent_project_id')->get();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;


        if(session('roles') == 1){
            // default to Admin view
            return view('pages.admin.forms.basicdetails', compact(
                'project',
                'rkns',
                'statuses',
                'clientMinistries',
                'projectManagers',
                'contractors',
                'architects',
                'mechanicalElectricals',
                'civilStructurals',
                'quantitySurveyors',
                'mainProjects',
                'progress'
            ));
        } else if(session('roles') == 2){
            return view('pages.project_manager.forms.basicdetails', compact(
                'project',
                'rkns',
                'statuses',
                'clientMinistries',
                'projectManagers',
                'contractors',
                'architects',
                'mechanicalElectricals',
                'civilStructurals',
                'quantitySurveyors',
                'mainProjects',
                'progress'
            ));
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $project = Project::with(['projectTeam.officerInCharge'])->findOrFail($id);

        // Check if user is admin or the project manager in charge
        if (session('roles') != 1 && // not admin
            (!$project->projectTeam || // no project team
             $project->projectTeam->officer_in_charge != $user->id)) { // not the officer in charge
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        if($project){
            $project->delete();
            $message = Str::limit($project->title.' has been deleted.', 250);
            sendNotification('update_project_details', $message);

            // Redirect based on user role
            if(session('roles') == 1) {
                return redirect()->route('pages.admin.projectsList')->with('success', 'Project <strong>'.$project->title. '</strong> was deleted successfully.');
            } else {
                return redirect()->route('pages.project_manager.projectsList')->with('success', 'Project <strong>'.$project->title. '</strong> was deleted successfully.');
            }
        }

        // Redirect based on user role
        if(session('roles') == 1) {
            return redirect()->route('pages.admin.projectsList')->with('error', 'Project not found.');
        } else {
            return redirect()->route('pages.project_manager.projectsList')->with('error', 'Project not found.');
        }
    }

    // store basicdetails form
    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());

        // validate input
        $request->validate([
            'rkn_id' => 'nullable|exists:rkn,id',
            'fy' => 'required|string',
            'sv' => 'required|string',
            'av' => 'required|string',
            'parent_project_id' => 'nullable|exists:project,id',
            'voteNum' => 'required|string',
            'title' => 'required|string',
            'client_ministry_id' => 'nullable|integer',
            'handoverDate' => 'nullable|date',
            'siteGazette' => 'nullable|string',
            'scope' => 'nullable|string',
            'location' => 'nullable|string',
            'img' => $imgPath = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // remove dollar signs and commas sv and av fields (clean values)
        $sv = preg_replace('/[^\d.]/', '', $request->input('sv'));
        $av = preg_replace('/[^\d.]/', '', $request->input('av'));

        // log to verify cleaned values
        Log::info('Cleaned sv: ' . $sv);
        Log::info('Cleaned av: ' . $av);

        // log to see if the file is present in the request
        if ($request->hasFile('img')) {
            Log::info('File Uploaded: ' . $request->file('img')->getClientOriginalName());
            $imgPath = $request->file('img')->store('images', 'public');
            Log::info('Image path: ' . $imgPath);
        } else {
            Log::info('No file uploaded');
            $imgPath = null;
        }

        $voteNum = $request->voteNum;

        // fetch voteNum from parent project for child project
        if ($request->parent_project_id) {
            $parentProject = Project::find($request->parent_project_id);
            if ($parentProject) {
                $voteNum = $parentProject->voteNum;
            }
        }

        // create a new Project
        $project = Project::create([
            'rkn_id' => $request['rkn_id'],
            'fy' => $request['fy'],
            'sv' => $sv,
            'av' => $av,
            'parent_project_id' => $request['parent_project_id'],
            'voteNum' => $request['voteNum'],
            'title' => $request['title'],
            'client_ministry_id' => $request['client_ministry_id'],
            'handoverDate' => $request['handoverDate'],
            'siteGazette' => $request['siteGazette'],
            'scope' => $request['scope'],
            'location' => $request['location'],
            'img' => $imgPath,
            'created_by' => auth()->id(),
        ]);

        // automatically checked first milestone when project is created
        $milestones = Milestone::all();
        foreach($milestones as $index => $milestone) {
            $project->milestones()->attach($milestone, ['completed' => $index === 0 ? true : false]);
        }

        // Log to confirm insertion
        Log::info('Project created: ', $project->toArray());
        $message = Str::limit('A new project ' . $project->title . ' has been added.', 250);
        sendNotification('new_project', $message);

        $mainProjects = Project::whereNull('parent_project_id')->get();
        // redirect with success notification
        if(session('roles') == 1) {
            return redirect()->route('pages.admin.projectsList')->with('success', 'Project <strong>'.$project->title. '</strong> was added successfully!');
        } elseif (session('roles') == 2){
            \App\Models\ProjectTeam::create([
                'project_id' => $project->id,
                'officer_in_charge' => auth()->id(),
            ]);
            return redirect()->route('pages.project_manager.projectsList')->with('success', 'Project <strong>'.$project->title. '</strong> was added successfully!');
        }

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
            'rkn_id' => 'nullable|exists:rkn,id',
            'fy' => 'required|string',
            'sv' => 'required|string',
            'av' => 'required|string',
            'parent_project_id' => 'nullable|exists:project,id',
            'voteNum' => 'required|string',
            'title' => 'required|string',
            'client_ministry_id' => 'nullable|integer',
            'handoverDate' => 'nullable|date',
            'siteGazette' => 'nullable|string',
            'scope' => 'nullable|string',
            'location' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Clean up the sv and av fields (remove dollar signs and commas)
        $sv = preg_replace('/[^\d.]/', '', $request->input('sv'));
        $av = preg_replace('/[^\d.]/', '', $request->input('av'));

        // Log cleaned values
        Log::info('Cleaned sv: ' . $sv);
        Log::info('Cleaned av: ' . $av);

         // log to see if the file is present in the request
        if ($request->hasFile('img')) {
            Log::info('File Uploaded: ' . $request->file('img')->getClientOriginalName());
            $imgPath = $request->file('img')->store('images', 'public');
            Log::info('Image path: ' . $imgPath);
        } else {
            Log::info('No file uploaded');
            $imgPath = null;
        }

        $project = Project::findOrFail($id);
        Log::info('Before Update:', $project->toArray());


        // update the project with the new project_team_id
        $updated = $project->update([
            'rkn_id' => $request['rkn_id'],
            'fy' => $request['fy'],
            'sv' => $sv,
            'av' => $av,
            'parent_project_id' => $request['parent_project_id'],
            'voteNum' => $request['voteNum'],
            'title' => $request['title'],
            'client_ministry_id' => $request['client_ministry_id'],
            'handoverDate' => $request['handoverDate'],
            'siteGazette' => $request['siteGazette'],
            'scope' => $request['scope'],
            'location' => $request['location'],
            'img' => $imgPath,
            'created_by' =>  auth()->id(),
        ]);

        // automatically checked first milestone when project is created
        $milestones = Milestone::all();
        foreach($milestones as $index => $milestone) {
        $project->milestones()->attach($milestone, ['completed' => $index === 0 ? true : false]);
        }

        $message = Str::limit('Project ' . $project->title . ' details have been updated.', 250);
        sendNotification('update_project_details', $message);

        // log success or failure of project update
        if ($updated) {
            Log::info('Project Updated successfully', $project->toArray());
        } else {
            Log::info('Project Update failed: ', $project->toArray());
        }

        // return the success response
        if(session('roles') == 1) {
            return redirect()->route('pages.admin.projectsList')->with('success', 'Project updated successfully!');
        } elseif (session('roles') == 2){
            return redirect()->route('pages.project_manager.projectsList')->with('success', 'Project updated successfully!');
        }
    }

    public function getVoteNum($id)
    {
        $parentProject = Project::findOrFail($id);
        return response()->json(['voteNum' => $parentProject->voteNum]); // return corresponding voteNum
    }

    public function downloadPdf($id)
    {
        $user = auth()->user();
        $project = Project::with(['projectTeam.officerInCharge'])->findOrFail($id);

        // check current user logged in
        if (session('roles') != 1 && // not admin
            (!$project->projectTeam || // no project team
             $project->projectTeam->officer_in_charge != $user->id)) { // not the officer in charge
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // Use different views based on role
        $view = session('roles') == 1 ? 'pages.admin.report-pdf' : 'pages.project_manager.report-pdf';

        $pdf = PDF::loadView($view, compact('project'));
        $pdf->setPaper('a3', 'landscape');
        return $pdf->download('project-details-' . $project->id . '.pdf');
    }

    // add  project_team method to handle project team form
    public function project_team($id)
    {
        // fetch project details using the ID
        $project = Project::findOrFail($id);

        // retrieve lists of project managers (oic)
        $projectManagerRoleId = 2;
        $projectManagers = User::where('roles_id', 2)->get();

        // retrieve lists of architect
        $architects = Architect::all();

        // retrieve lists of mechanical electrical
        $mechanicalElectricals = MechanicalElectrical::all();

        // retrieve lists of civil structural
        $civilStructurals = CivilStructural::all();

        // retrieve lists of quantity surveyor
        $quantitySurveyors = QuantitySurveyor::all();

        // get all milestones for the project
        $milestones = $project->milestones;

        // calculate progress
        $totalMilestones = $milestones->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;

        // return the success response
        if(session('roles') == 1) {
            return view('pages.admin.forms.project_team', compact('project', 'projectManagers', 'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'progress'));
        } elseif (session('roles') == 2){
            return view('pages.project_team.forms.project_team', compact('project', 'projectManagers', 'architects', 'mechanicalElectricals', 'civilStructurals', 'quantitySurveyors', 'progress'));
        }

    }

}


?>
