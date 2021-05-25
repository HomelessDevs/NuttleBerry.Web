<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\GroupController;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\ProfileController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//some chacnges
Route::name('api.')->group(function () {
    Route::middleware('throttle')->group(function () {
        Route::post('login', [ProfileController::class, 'login'])->name('profile.login');
    });
    Route::middleware('auth:api', 'throttle')->group(function () {
        Route::apiResource('group', GroupController::class)->name('*', 'group');
        Route::apiResource('course', CourseController::class)->name('*', 'course');
        Route::apiResource('profile', ProfileController::class)->name('*', 'profile');
        Route::apiResource('task', TaskController::class)->name('*', 'task');
        ////////////////////////////////////////////ANSWERS////////////////////////////////////////////
        Route::post('task/{id}/rate', [TaskController::class, 'rate'])->name('task.rate');
        Route::post('task/{id}/answer', [TaskController::class, 'answer'])->name('task.answer');
        Route::post('task/{id}/edit-answer', [TaskController::class, 'editAnswer'])->name('task.edit.answer');
        Route::get('task/{id}/download', [TaskController::class, 'download'])->name('task.download');
        Route::get('task/{id}/completed', [TaskController::class, 'completed'])->name('task.completed');
        ////////////////////////////////////////////PROFILE////////////////////////////////////////////
        Route::post('logout', [ProfileController::class, 'logout'])->name('profile.logout');
    });
});
