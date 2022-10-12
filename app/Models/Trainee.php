<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'address',
        'image',
        'link',
        'total_income',
        'job_number',
        'gender',
        'level',
        'status',
        'created_at',
        'updated_at',
    ];

    public function course_attendances()
    {
        return $this->hasMany(CourseAttendance::class );
    }



}
