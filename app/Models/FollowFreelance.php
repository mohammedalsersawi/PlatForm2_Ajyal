<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowFreelance extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected function serializeDate(DateTimeInterface $dates)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dates)->format('Y-m-d');
    }


    protected $fillable = [
        'Platform',
        'title',
        'details',
        'budget',
        'date',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'user_id');
    }


}
