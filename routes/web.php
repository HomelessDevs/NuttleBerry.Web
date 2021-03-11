<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('main-page');
})->name('main');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('profile', ProfileController::class)->name('*', 'profile')->only(['show', 'edit', 'update', 'destroy']);
    Route::resource('group', GroupController::class)->name('*', 'group')->only(['edit', 'update', 'destroy', 'index', 'store']);
    Route::resource('course', CourseController::class)->name('*', 'course')->only(['edit', 'update', 'destroy', 'create', 'store']);
    Route::resource('task', TaskController::class)->name('*', 'task')->only(['edit', 'update', 'destroy', 'create', 'store', 'show']);
    Route::get('group/{id}', [CourseController::class, 'index'])->name('course.index');
    Route::get('group/{id}/register', [CourseController::class, 'register'])->name('course.register');
    Route::get('course/{id}', [TaskController::class, 'index'])->name('task.index');
    Route::get('my-courses', [CourseController::class, 'myCourses'])->name('course.myCourses');
    Route::put('profile/{id}/promote', [ProfileController::class, 'promote'])->name('profile.promote');
    Route::get('journal', [TaskController::class, 'journal'])->name('task.journal');
    Route::get('task/{id}/download', [TaskController::class, 'download'])->name('task.download');
    Route::get('task/{id}/completed', [TaskController::class, 'completed'])->name('task.completed');
    Route::get('administrating', [GroupController::class, 'administrating'])->name('administrating');
    Route::post('task/{id}/answer', [TaskController::class, 'answer'])->name('task.answer');
    Route::post('task/{id}/edit-answer', [TaskController::class, 'editAnswer'])->name('task.edit.answer');
    Route::post('task/{id}/rate', [TaskController::class, 'rate'])->name('task.rate');
});
Route::redirect('home', '/');
//testssssdadasdaw
