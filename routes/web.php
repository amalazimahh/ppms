<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PreTenderController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProjectTeamContoller;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
        Route::get('addprojects', [ProjectsController::class, 'addprojects'])->name('pages.addprojects');
        Route::post('addprojects/store', [ProjectsController::class, 'store'])->name('projects.store');
        // Route::post('notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        // Route::get('notifications/get', [NotificationController::class, 'getNotifications'])->name('notifications.get');
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

    // admin
    // Route::get('/admin/dashboard', [PageController::class, 'adminDashboard'])->name('pages.admin.dashboard')->middleware('auth');
    Route::get('/admin/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('pages.admin.project-dashboard')->middleware('auth');
    Route::get('/admin/projects/{id}/basicdetails', [ProjectsController::class, 'basicdetails'])->name('pages.admin.forms.basicdetails')->middleware('auth');
    Route::post('/admin/basicdetails/store', [ProjectsController::class, 'store'])->name('pages.admin.forms.basicdetails.store')->middleware('auth');
    Route::post('/projects/store', [ProjectsController::class, 'store'])->name('projects.store')->middleware('auth');
    Route::get('/admin/user_management', [PageController::class, 'manageUsers'])->name('pages.admin.user_management')->middleware('auth');
    Route::get('/admin/projectsList', [ProjectsController::class, 'index'])->name('pages.admin.projectsList')->middleware('auth');
    Route::get('admin/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit')->middleware('auth');
    Route::put('admin/projects/{id}/update', [ProjectsController::class, 'update'])->name('pages.admin.forms.basicdetails.update');
    Route::get('admin/projects/{id}/status', [MilestoneController::class, 'milestone'])->name('projects.status')->middleware('auth');
    Route::get('admin/projects/{id}/project_team', [ProjectsController::class, 'project_team'])->name('projects.project_team')->middleware('auth');
    Route::get('admin/projects/{id}/pre_tender', [PreTenderController::class, 'edit'])->name('projects.pre_tender')->middleware('auth');
    Route::put('admin/projects/{id}/pre_tender', [PreTenderController::class, 'update'])->name('projects.pre_tender.update')->middleware('auth');
    Route::get('admin/projects/{id}/design_submission', [ProjectsController::class, 'designSubmission'])->name('projects.design_submission')->middleware('auth');
    Route::get('admin/projects/{id}/tender', [ProjectsController::class, 'tender'])->name('projects.tender')->middleware('auth');
    Route::get('admin/projects/{id}/tender_recommendation', [ProjectsController::class, 'tender_recommendation'])->name('projects.tender_recommendation')->middleware('auth');
    Route::get('admin/projects/{id}/approval_award', [ProjectsController::class, 'approval_award'])->name('projects.approval_award')->middleware('auth');
    Route::get('admin/projects/{id}/contract', [ProjectsController::class, 'contract'])->name('projects.contract')->middleware('auth');
    Route::get('admin/projects/{id}/bankers_guarantee', [ProjectsController::class, 'bankers_guarantee'])->name('projects.bankers_guarantee')->middleware('auth');
    Route::get('admin/projects/{id}/insurance', [ProjectsController::class, 'insurance'])->name('projects.insurance')->middleware('auth');
    Route::delete('admin/projects/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy')->middleware('auth');
    Route::get('admin/projects/{id}/getVoteNum', [ProjectsController::class, 'getVoteNum'])->middleware('auth');
    Route::get('admin/projects/{id}/view', [ProjectsController::class, 'view'])->name('pages.view_project')->middleware('auth');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('pages.admin.dashboard')->middleware('auth');
    // Route::get('/admin/project_team', [ProjectTeam::class, 'manageTeam'])->name('pages.admin.project_team')->middleware('auth');

    // project manager
    Route::get('/project_manager/dashboard', [PageController::class, 'projectDashboard'])->name('pages.project_manager.dashboard')->middleware('auth');
    Route::get('/project_manager/basicdetails', [ProjectsController::class, 'basicdetails'])->name('pages.project_manager.forms.basicdetails')->middleware('auth');
    Route::get('/project_manager/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('pages.project_manager.project-dashboard')->middleware('auth');
    Route::get('/project_manager/projectsList', [PageController::class, 'projectList'])->name('pages.project_manager.projectsList')->middleware('auth');
    Route::get('/project_manager/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit')->middleware('auth');

    // executive
    Route::get('/executive/dashboard', [PageController::class, 'executiveDashboard'])->name('pages.executive.dashboard')->middleware('auth');
    Route::get('/executive/project-dashboard', [PageController::class, 'projectSpecificDashboard'])->name('pages.executive.project-dashboard')->middleware('auth');
    Route::get('/executive/projectsList', [PageController::class, 'projectList'])->name('pages.executive.projectsList')->middleware('auth');

});
