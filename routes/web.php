<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PreTenderController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProjectTeamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectDashboardController;
use App\Http\Controllers\ProjectMilestoneController;
use App\Http\Controllers\DesignSubmissionController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\TenderRecommendationController;
use App\Http\Controllers\ApprovalAwardController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\BankerGuaranteeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\RKNController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectHealthController;
use App\Http\Controllers\HomeController;

Route::get('/', [PageController::class, 'dashboard']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
        Route::get('addprojects', [ProjectsController::class, 'addprojects'])->name('pages.addprojects');
        Route::post('addprojects/store', [ProjectsController::class, 'store'])->name('projects.store');
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::middleware(['auth'])->group(function (){
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('pages.notification.index');
    Route::post('/notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::get('/notifications/{id}', [NotificationController::class, 'destroy'])->name('pages.notification.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('pages.notification.destroyAll');

    Route::get('/admin/projects/{id}/basicdetails', [ProjectsController::class, 'basicdetails'])->name('pages.admin.forms.basicdetails')->middleware('auth');
    Route::post('/admin/basicdetails/store', [ProjectsController::class, 'store'])->name('pages.admin.forms.basicdetails.store')->middleware('auth');
    Route::post('/projects/store', [ProjectsController::class, 'store'])->name('projects.store')->middleware('auth');
    Route::get('/admin/user_management', [PageController::class, 'manageUsers'])->name('pages.admin.user_management')->middleware('auth');
    Route::get('/admin/contractor', [PageController::class, 'manageContractors'])->name('pages.admin.contractor')->middleware('auth');
    Route::get('/admin/projectsList', [ProjectsController::class, 'index'])->name('pages.admin.projectsList')->middleware('auth');
    Route::get('admin/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('pages.admin.forms.basicdetails')->middleware('auth');
    Route::put('admin/projects/{id}/update', [ProjectsController::class, 'update'])->name('pages.admin.forms.basicdetails.update');
    Route::get('admin/projects/{id}/status', [MilestoneController::class, 'milestone'])->name('projects.status')->middleware('auth');
    Route::get('admin/projects/{id}/project_team', [ProjectsController::class, 'project_team'])->name('projects.project_team')->middleware('auth');
    Route::put('/projects/{id}/project_team', [ProjectTeamController::class, 'update'])->name('projects.project_team.update');
    Route::get('admin/projects/{id}/pre_tender', [PreTenderController::class, 'edit'])->name('projects.pre_tender')->middleware('auth');
    Route::put('admin/projects/{id}/pre_tender', [PreTenderController::class, 'update'])->name('projects.pre_tender.update')->middleware('auth');
    Route::get('admin/projects/{id}/design_submission', [DesignSubmissionController::class, 'edit'])->name('projects.design_submission')->middleware('auth');
    Route::put('admin/projects/{id}/design_submission', [DesignSubmissionController::class, 'update'])->name('projects.design_submission.update')->middleware('auth');
    Route::get('admin/projects/{id}/tender', [TenderController::class, 'edit'])->name('projects.tender')->middleware('auth');
    Route::put('admin/projects/{id}/tender', [TenderController::class, 'update'])->name('projects.tender.update')->middleware('auth');
    Route::get('admin/projects/{id}/tender_recommendation', [TenderRecommendationController::class, 'edit'])->name('projects.tender_recommendation')->middleware('auth');
    Route::put('admin/projects/{id}/tender_recommendation', [TenderRecommendationController::class, 'update'])->name('projects.tender_recommendation.update')->middleware('auth');
    Route::get('admin/projects/{id}/approval_award', [ApprovalAwardController::class, 'edit'])->name('projects.approval_award')->middleware('auth');
    Route::put('admin/projects/{id}/approval_award', [ApprovalAwardController::class, 'update'])->name('projects.approval_award.update')->middleware('auth');
    Route::get('admin/projects/{id}/contract', [ContractController::class, 'edit'])->name('projects.contract')->middleware('auth');
    Route::put('admin/projects/{id}/contract', [ContractController::class, 'update'])->name('projects.contract.update')->middleware('auth');
    Route::get('admin/projects/{id}/bankers_guarantee', [BankerGuaranteeController::class, 'edit'])->name('projects.bankers_guarantee')->middleware('auth');
    Route::put('admin/projects/{id}/bankers_guarantee', [BankerGuaranteeController::class, 'update'])->name('projects.bankers_guarantee.update')->middleware('auth');
    Route::get('admin/projects/{id}/insurance', [InsuranceController::class, 'edit'])->name('projects.insurance')->middleware('auth');
    Route::put('admin/projects/{id}/insurance', [InsuranceController::class, 'update'])->name('projects.insurance.update')->middleware('auth');
    Route::delete('admin/projects/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy')->middleware('auth');
    Route::get('admin/projects/{id}/getVoteNum', [ProjectsController::class, 'getVoteNum'])->middleware('auth');
    Route::get('admin/projects/{id}/view', [ProjectsController::class, 'view'])->name('pages.view_project')->middleware('auth');
    // Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('pages.admin.dashboard')->middleware('auth');
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('pages.admin.dashboard')->middleware('auth');
    Route::get('/admin/project-dashboard', [ProjectDashboardController::class, 'projectSpecificDashboard'])->name('pages.admin.project-dashboard')->middleware('auth');
    Route::get('/admin/project-dashboard', [ProjectDashboardController::class, 'index'])->name('pages.admin.project-dashboard')->middleware('auth');
    // Route::get('/admin/project_team', [ProjectTeam::class, 'manageTeam'])->name('pages.admin.project_team')->middleware('auth');
    Route::get('/admin/projects/{id}/download-PDF', [ProjectsController::class, 'downloadPDF'])->name('projects.downloadPDF')->middleware('auth');
    Route::get('/admin/project_team', [ProjectTeamController::class, 'manageProjectTeam'])->name('pages.admin.project_team')->middleware('auth');
    Route::post('/admin/project-team/add-discipline', [ProjectTeamController::class, 'addDiscipline'])->name('admin.project_team.addDiscipline');
    Route::post('/admin/project-team/delete-discipline', [ProjectTeamController::class, 'deleteDiscipline'])->name('admin.project_team.deleteDiscipline');
    Route::post('/projects/{project}/milestones/{milestone}/toggle', [ProjectMilestoneController::class, 'toggle'])->name('projects.milestones.toggle');
    Route::get('/projects/{project}/progress', [ProjectMilestoneController::class, 'getProgress'])->name('projects.progress');
    Route::get('/admin/rkn', [RKNController::class, 'showRKN'])->name('pages.admin.rkn')->middleware('auth');
    Route::post('/admin/rkn', [RKNController::class, 'store'])->name('pages.admin.rkn.store')->middleware('auth');
    Route::post('/admin/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('admin.assignRole');
    Route::get('admin/projects/{id}/project_health', [ProjectHealthController::class, 'show'])->name('projects.project_health')->middleware('auth');
    Route::put('admin/projects/{id}/project_health', [ProjectHealthController::class, 'update'])->name('projects.project_health.update')->middleware('auth');

    // project manager
    Route::get('/project_manager/dashboard', [DashboardController::class, 'dashboard'])->name('pages.project_manager.dashboard')->middleware('auth');
    Route::get('/project_manager/basicdetails', [ProjectsController::class, 'basicdetails'])->name('pages.project_manager.forms.basicdetails')->middleware('auth');
    Route::get('/project_manager/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('pages.project_manager.project-dashboard')->middleware('auth');
    Route::get('/project_manager/projectsList', [PageController::class, 'projectList'])->name('pages.project_manager.projectsList')->middleware('auth');
    Route::get('/project_manager/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit')->middleware('auth');

    // executive
    Route::get('/executive/dashboard', [PageController::class, 'executiveDashboard'])->name('pages.executive.dashboard')->middleware('auth');
    Route::get('/executive/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('pages.executive.project-dashboard')->middleware('auth');
    Route::get('/executive/projectsList', [PageController::class, 'projectList'])->name('pages.executive.projectsList')->middleware('auth');

});

