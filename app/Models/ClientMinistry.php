<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientMinistry extends Model
{
    use HasFactory;

    protected $table = 'client_ministry';
    protected $fillable = ['ministryName', 'created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public $timestamps = false;
}
