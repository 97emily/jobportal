<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\Product\Bulk\StatusController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Resource\Bulk\DeleteResourcesController as BulkDeleteResourcesController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\PracticalTestController;
use App\Http\Controllers\Admin\PracticalQuestionController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SalaryRangeController;
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\API\JobApiController;

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('assessments', AssessmentController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('jobs', JobController::class);
    Route::get('jobs/applicants', [JobController::class,'applicants'])->name('jobs.applicants');
    Route::get('jobs/{id}/shortlisted', [JobApiController::class, 'shortlisted'])->name('jobs.shortlisted');
    Route::get('jobs/{user_id}/shortlistedapplicantdetails', [JobApiController::class, 'shortlistedapplicantdetails'])->name('jobs.shortlisted.applicant');
    Route::put('/updateshortlistedapplicantdetails', [JobApiController::class, 'updateApplicant'])->name('updateshortlistedapplicantdetails');
    // Route::post('/send-tests/{job_id}', [PracticalTestController::class, 'sendTests'])->name('send.tests');
    Route::post('jobs/{job}/sendPracticalTest', [PracticalTestController::class, 'sendPracticalTest'])->name('jobs.sendPracticalTest');
    Route::post('/schedule-interview', [InterviewController::class, 'schedule'])->name('scheduleInterview');
    Route::get('/get-form-details', [InterviewController::class, 'getFormDetails'])->name('getFormDetails');

    // Route::resource('products', ProductController::class);
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('salary_ranges', SalaryRangeController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('practical_tests', PracticalTestController::class);
    Route::resource('practical_questions', PracticalQuestionController::class);
    Route::resource('interviews', InterviewController::class);


    require __DIR__.'/admin_generator.php';
});
