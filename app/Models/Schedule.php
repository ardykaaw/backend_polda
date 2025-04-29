<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'day',
        'time_start',
        'time_end',
        'location'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'schedule_members');
    }
}
