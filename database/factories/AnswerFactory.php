<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $myCourses = DB::table('my_courses')->select('user_id','course_id')->get();
        $myCoursesData = array();
        foreach ($myCourses as $course){
            $myCoursesData[$course->user_id] = $course->course_id;
        }

        $courses = DB::table('courses')->select('id')->whereIn('id', $myCoursesData)->get();
        $coursesIDs = array();
        foreach ($courses as $course){
            $coursesIDs[] = $course->id;
        }

        $tasks = DB::table('tasks')->select('id')->whereIn('course_id', $coursesIDs)->get();
        $tasksIDs = array();
        foreach ($tasks as $task){
            $tasksIDs[] = $task->id;
        }
        return [
            'task_id' => $this->faker->randomElement($tasksIDs),
            'user_id' => array_rand($myCoursesData),
            'message' => $this->faker->text(50),
            'rating' => $this->faker->numberBetween(1, 5),
            ];
    }
}
