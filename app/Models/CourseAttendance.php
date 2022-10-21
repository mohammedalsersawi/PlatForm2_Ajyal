<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttendance extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'attendance_trainees' );
    }

    public function cococ()
    {
        return $this->hasMany(AttendanceTrainee::class);
    }



}
