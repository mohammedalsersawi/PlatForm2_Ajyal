<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latestupdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'details',
        'sending_date',
        'start_date',
    ];
}
