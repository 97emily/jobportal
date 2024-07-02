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
    // Route::resource('products', ProductController::class);
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('salary_ranges', SalaryRangeController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('practical_tests', PracticalTestController::class);
    Route::resource('practical_questions', PracticalQuestionController::class);


    require __DIR__.'/admin_generator.php';
});
