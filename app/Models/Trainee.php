<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'user_id';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function course_attendances()
    {
        return $this->hasMany(CourseAttendance::class );
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_trainees' ,'trainee_id');
    }




}
