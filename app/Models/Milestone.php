<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Milestone extends Model
{
    use HasFactory;

    protected $table = 'milestones';

    protected $fillable = [
        'statuses_id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'statuses_id');
    }
}
