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
        'customID', 'fy', 'sv', 'av', 'statuses_id', 'voteNum',
        'title', 'oic', 'client_ministry_id', 'contractor_id', 'contractorNum',
        'siteGazette', 'soilInv', 'topoSurvey', 'handover',
        'scope', 'location', 'img', 'project_team_id',
        'created_by', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'soilInv' => 'date',
        'topoSurvey' => 'date',
        'handover' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public $timestamps = false;

    // relationship with ProjectTeam model
    public function projectTeam(){
        return $this->belongsTo(ProjectTeam::class, 'project_team_id');
    }

    // relationship with User model for oic and created_by
    public function oicUser(){
        return $this->belongsTo(User::class, 'oic');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relationship with Statuses model
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    // relationship with ClientMinistry model
    public function clientMinistry(){
        return $this->belongsTo(ClientMinistry::class, 'client_ministry_id');
    }

    // relationship with Contractor model
    public function contractor(){
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
