<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $fillable = ['name', 'created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public $timestamps = false;

    // public function projects(){
    //     return $this->hasMany(Project::class);
    // }
}
