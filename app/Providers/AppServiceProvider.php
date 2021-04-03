<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Course;
use App\Models\Task;
use App\Models\Answer;
use App\Models\MyCourses;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function () {
            if (Auth::user()) {
                $user = Auth::user();
                $count = 0;
            /*    if ($user->role == 'student') {
                    $count = count(Answer::where([['user_id', $user->id], ['status', 'Оцінено']])->get());
            */
                if ($user->role == 'teacher' || $user->role == 'admin') {
                    $courseIDs = Course::where('teacher_id', $user->id)->pluck('id');
                    $tasksIDs = Task::whereIn('course_id', $courseIDs)->pluck('id');
                    $count = Answer::whereIn('task_id', $tasksIDs)->where('status','Не оцінено')->count();

                }
                view()->share('count', $count);
            }
        });
    }
}
