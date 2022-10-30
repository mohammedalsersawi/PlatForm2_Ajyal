<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Latestupdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'details',
        'sending_date',
        'start_date',
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected function serializeDate(DateTimeInterface $dates)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dates)->format('Y-m-d');
    }
}
