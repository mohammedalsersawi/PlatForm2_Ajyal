<?php

namespace App\Models;

use App\Models\CourseAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceTrainee extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',

    ];


    public function course_attendances()
    {
        return $this->belongsTo(CourseAttendance::class,'course_attendance_id');
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'attendance_trainees' , 'trainee_id', 'id','user_id' );
    }
    public function trainee()
    {
        return $this->belongsTo(Trainee::class,'trainee_id','user_id');
    }

}
