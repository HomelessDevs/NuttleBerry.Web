<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $courseIDs = DB::table('courses')->select('id')->get();
        $IDs = array();
        foreach ($courseIDs as $group){
            $IDs[] = $group->id;
        }
        return [
            'course_id' => $this->faker->randomElement($IDs),
            'title' => $this->faker->company,
            'type' => $this->faker->randomElement(array('practice','theory','advertisement')),
            'topic' => $this->faker->word(),
            'description' => $this->faker->text(50),
        ];
    }
}
