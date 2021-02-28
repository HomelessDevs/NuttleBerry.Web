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
        User::create(['name' => 'root', 'role' => 'admin', 'email_verified_at' => now(), 'email' => 'root@example.com', 'password' => bcrypt('root')]);
        Group::factory()->count(5)->create();
        Course::factory()->count(10)->create();
        MyCourses::factory()->count(2)->create();
        Task::factory()->count(15)->create();
        Answer::factory()->count(10)->create();

    }
}
