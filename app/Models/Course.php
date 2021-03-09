<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\Group;

class Course extends Model
{
    use HasFactory;
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
