<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhysicalStatus extends Model
{
    use HasFactory;

    protected $table = 'physical_status';
    protected $fillable = [
        'project_id',
        'scheduled',
        'actual'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
