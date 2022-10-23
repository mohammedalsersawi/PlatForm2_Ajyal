<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesTrainee extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainee_id',
        'course_id',
    ];
}
