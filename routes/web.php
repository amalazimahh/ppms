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

Route::middleware(['auth'])->group(function () {
    // Common routes accessible by all authenticated users
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('pages.notification.index');
    Route::post('/notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::get('/notifications/{id}', [NotificationController::class, 'destroy'])->name('pages.notification.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('pages.notification.destroyAll');

    // Common project routes used across roles
    Route::post('/projects/{project}/milestones/{milestone}/toggle', [ProjectMilestoneController::class, 'toggle'])->name('projects.milestones.toggle');
    Route::get('/projects/{project}/progress', [ProjectMilestoneController::class, 'getProgress'])->name('projects.progress');
    Route::put('/projects/{id}/project_team', [ProjectTeamController::class, 'update'])->name('projects.project_team.update');

    // Admin Routes
    Route::prefix('admin')->name('pages.admin.')->group(function () {
        // Dashboard & Overview
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/project-dashboard', [ProjectDashboardController::class, 'index'])->name('project-dashboard');

        // Project Management
        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectsController::class, 'index'])->name('projectsList');
            Route::get('/{id}/basicdetails', [ProjectsController::class, 'basicdetails'])->name('forms.basicdetails');
            Route::post('/basicdetails/store', [ProjectsController::class, 'store'])->name('forms.basicdetails.store');
            Route::get('/{id}/edit', [ProjectsController::class, 'edit'])->name('forms.basicdetails');
            Route::put('/{id}/update', [ProjectsController::class, 'update'])->name('forms.basicdetails.update');
            Route::delete('/{id}', [ProjectsController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/view', [ProjectsController::class, 'view'])->name('view_project');
            Route::get('/{id}/download-PDF', [ProjectsController::class, 'downloadPDF'])->name('downloadPDF');

            // Project Components
            Route::get('/{id}/status', [MilestoneController::class, 'milestone'])->name('status');
            Route::get('/{id}/project_team', [ProjectsController::class, 'project_team'])->name('project_team');
            Route::get('/{id}/pre_tender', [PreTenderController::class, 'edit'])->name('pre_tender');
            Route::put('/{id}/pre_tender', [PreTenderController::class, 'update'])->name('pre_tender.update');
            Route::get('/{id}/design_submission', [DesignSubmissionController::class, 'edit'])->name('design_submission');
            Route::put('/{id}/design_submission', [DesignSubmissionController::class, 'update'])->name('design_submission.update');
            Route::get('/{id}/tender', [TenderController::class, 'edit'])->name('tender');
            Route::put('/{id}/tender', [TenderController::class, 'update'])->name('tender.update');
            Route::get('/{id}/tender_recommendation', [TenderRecommendationController::class, 'edit'])->name('tender_recommendation');
            Route::put('/{id}/tender_recommendation', [TenderRecommendationController::class, 'update'])->name('tender_recommendation.update');
            Route::get('/{id}/approval_award', [ApprovalAwardController::class, 'edit'])->name('approval_award');
            Route::put('/{id}/approval_award', [ApprovalAwardController::class, 'update'])->name('approval_award.update');
            Route::get('/{id}/contract', [ContractController::class, 'edit'])->name('contract');
            Route::put('/{id}/contract', [ContractController::class, 'update'])->name('contract.update');
            Route::get('/{id}/bankers_guarantee', [BankerGuaranteeController::class, 'edit'])->name('bankers_guarantee');
            Route::put('/{id}/bankers_guarantee', [BankerGuaranteeController::class, 'update'])->name('bankers_guarantee.update');
            Route::get('/{id}/insurance', [InsuranceController::class, 'edit'])->name('insurance');
            Route::put('/{id}/insurance', [InsuranceController::class, 'update'])->name('insurance.update');
            Route::get('/{id}/project_health', [ProjectHealthController::class, 'show'])->name('project_health');
            Route::put('/{id}/project_health', [ProjectHealthController::class, 'update'])->name('project_health.update');
            Route::get('/{id}/getVoteNum', [ProjectsController::class, 'getVoteNum'])->name('getVoteNum');
        });

        // Team Management
        Route::get('/project_team', [ProjectTeamController::class, 'manageProjectTeam'])->name('project_team');
        Route::post('/project-team/add-discipline', [ProjectTeamController::class, 'addDiscipline'])->name('project_team.addDiscipline');
        Route::post('/project-team/delete-discipline', [ProjectTeamController::class, 'deleteDiscipline'])->name('project_team.deleteDiscipline');

        // Other Admin Features
        Route::get('/user_management', [PageController::class, 'manageUsers'])->name('user_management');
        Route::get('/contractor', [PageController::class, 'manageContractors'])->name('contractor');
        Route::get('/rkn', [RKNController::class, 'showRKN'])->name('rkn');
        Route::post('/rkn', [RKNController::class, 'store'])->name('rkn.store');
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('assignRole');
    });

    // Project Manager Routes
    Route::prefix('project_manager')->name('pages.project_manager.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/project-dashboard', [ProjectDashboardController::class, 'index'])->name('project-dashboard');
        Route::get('/projectsList', [ProjectsController::class, 'index'])->name('projectsList');
        Route::get('/basicdetails', [ProjectsController::class, 'basicdetails'])->name('forms.basicdetails');
        Route::get('/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('edit');
    });

    // Executive Routes
    Route::prefix('executive')->name('pages.executive.')->group(function () {
        Route::get('/dashboard', [PageController::class, 'executiveDashboard'])->name('dashboard');
        Route::get('/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('project-dashboard');
        Route::get('/projectsList', [PageController::class, 'projectList'])->name('projectsList');
    });
});

