<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Course;
use App\Models\MyCourses;
use App\Models\Task;
use App\Models\Answer;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(['surname' => 'rootSurname', 'name' => 'root', 'role' => 'admin', 'email_verified_at' => now(), 'email' => 'root@example.com', 'password' => bcrypt('root')]);
        User::factory()->count(200)->create();
        Group::factory()->count(10)->create();
        Course::factory()->count(60)->create();
        MyCourses::factory()->count(100)->create();
        Task::factory()->count(1000)->create();
        //Answer::factory()->count(4)->create();

    }
}
