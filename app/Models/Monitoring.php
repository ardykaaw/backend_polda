<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'start_time',
        'end_time',
        'location',
        'additional_data'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];
}
