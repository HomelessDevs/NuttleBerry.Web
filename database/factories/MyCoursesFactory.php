<?php

namespace Database\Factories;

use App\Models\MyCourses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class MyCoursesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MyCourses::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tasks = DB::table('courses')->select('id')->get();
        $users = DB::table('users')->select('id')->get();
        $tasksIDs = array();
        $usersIDs = array();
        foreach ($tasks as $task){
            $tasksIDs[] = $task->id;
        }
        foreach ($users as $user){
            $usersIDs[] = $user->id;
        }
        return [
            'user_id' => $this->faker->randomElement($usersIDs),
            'course_id' => $this->faker->unique()->randomElement($tasksIDs),
        ];
    }
}
