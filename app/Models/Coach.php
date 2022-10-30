<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = 'user_id';
    protected $dates = ['created_at', 'updated_at'];
    protected function serializeDate(DateTimeInterface $dates)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $dates)->format('Y-m-d');
    }

    public function coaches()
    {
        return $this->belongsTo(User::class);
    }

}
