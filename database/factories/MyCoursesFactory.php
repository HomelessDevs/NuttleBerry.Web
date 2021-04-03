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
        $tasksIDs = DB::table('courses')->pluck('id');
        $usersIDs = DB::table('users')->pluck('id');
        return [
            'user_id' => $this->faker->randomElement($usersIDs),
            'course_id' => $this->faker->randomElement($tasksIDs),
        ];
    }
}
