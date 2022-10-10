<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttendance extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function course_attendances()
    {
        return $this->belongsToMany(Trainee::class, 'attendance_trainees' );
    }



}
