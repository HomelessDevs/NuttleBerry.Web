<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;

class Task extends Model
{
    use HasFactory;
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
}
