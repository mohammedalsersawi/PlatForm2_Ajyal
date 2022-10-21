<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceTrainee extends Model
{
    use HasFactory;
    protected $guarded = [];




    public function course_attendances()
    {
        return $this->belongsTo(CourseAttendance::class,'course_attendance_id');
    }

}
