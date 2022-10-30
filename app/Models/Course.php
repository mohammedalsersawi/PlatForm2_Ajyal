<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    protected function serializeDate(DateTimeInterface $dates)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dates)->format('Y-m-d');
    }

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
