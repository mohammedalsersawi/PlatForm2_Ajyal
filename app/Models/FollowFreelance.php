<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowFreelance extends Model
{
    use HasFactory;
    protected $fillable = [
        'Platform',
        'title',
        'details',
        'budget',
        'date',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
