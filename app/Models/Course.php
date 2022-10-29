<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'courses_trainees', 'course_id', 'trainee_id', 'id','user_id');
    }


    public function coaches()
    {
        return $this->belongsTo(Coach::class, 'user_id');
    }


    public function users()
    {
        return $this->belongsTo(Coach::class,'courses_coach_id');
    }



}
