<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workouts extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trainees()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }

    public function coaches()
    {
        return $this->belongsTo(Trainee::class, 'coach_id');
    }
}
