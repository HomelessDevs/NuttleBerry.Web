<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Task;
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
        $myCourses = DB::table('my_courses')->select('user_id', 'course_id')->get();
        $myCoursesData = array();
        foreach ($myCourses as $course) {
            $myCoursesData[$course->user_id] = $course->course_id;
        }
        $status = $this->faker->randomElement(array('Оцінено', 'Не оцінено'));
        $rating = "-";
        if ($status == 'Оцінено') {
            $rating = $this->faker->numberBetween(1, 5);
        }
        return [
            'task_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $this->faker->numberBetween(2, 10),
            'message' => $this->faker->text(50),
            'rating' => $rating,
            'status' => $status
        ];
    }
}
