<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'user_id';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected function serializeDate(DateTimeInterface $dates)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dates)->format('Y-m-d');
    }
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
