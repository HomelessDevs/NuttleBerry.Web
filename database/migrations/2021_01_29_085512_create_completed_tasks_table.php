<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();;
            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->string('file')->default("none");
            $table->string('message')->default("none");
            $table->string('teacher_feedback')->default("none");
            $table->enum('status', ['Оцінено', 'Не оцінено'])->default('Не оцінено');
            $table->string('rating')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completed_users_tasks');
    }
}
