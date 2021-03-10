<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Answer extends Model
{
    use HasFactory;
    public $table = "completed_tasks";
    public function users()
    {
        return $this->belongsToMany(Task::class);
    }
}
