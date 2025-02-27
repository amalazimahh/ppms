<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $primaryKey = 'id';

    protected $fillable = [
        'customID', 'fy', 'sv', 'av', 'voteNum', 'title',
        'oic', 'location', 'img', 'scope',
        'soilInv', 'topoSurvey', 'handover'
    ];

    protected $casts = [
        'soilInv' => 'date',
        'topoSurvey' => 'date',
        'handover' => 'date',
    ];

    public $timestamps = false;
}
