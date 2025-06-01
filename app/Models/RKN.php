<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RKN extends Model
{
    use HasFactory;

    protected $table = 'rkn';
    protected $fillable = [
        'rknNum',
        'startDate',
        'endDate',
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
