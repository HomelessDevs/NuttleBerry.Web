<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $groupNames = DB::table('groups')->select('id')->get();
        $IDs = array();
        foreach ($groupNames as $group){
            $IDs[] = $group->id;
        }
        return [
            'name' => 'course' . $this->faker->unique()->numberBetween(1, 1000),
            'group_id' => $this->faker->randomElement($IDs),
            'teacher_id' => '1'
        ];
    }
}
