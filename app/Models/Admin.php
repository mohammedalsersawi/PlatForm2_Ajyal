<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'user_id';

    public function admins()
    {
        return $this->belongsTo(User::class);
    }
}
