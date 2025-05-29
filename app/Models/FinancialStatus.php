<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialStatus extends Model
{
    use HasFactory;

    protected $table = 'financial_status';
    protected $fillable = [
        'project_id',
        'scheduled',
        'actual'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
