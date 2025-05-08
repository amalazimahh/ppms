<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuantitySurveyor extends Model
{
    use HasFactory;

    protected $table = 'quantity_surveyor';
    protected $fillable = ['name', 'created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public $timestamps = true;
}
