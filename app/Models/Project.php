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
        'rkn_id', 'fy', 'sv', 'av', 'voteNum', 'title', 'siteGazette',
        'scope', 'location', 'statuses_id', 'parent_project_id',
        'client_ministry_id', 'handoverDate', 'img', 'milestones_id',
        'created_by', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public $timestamps = true;

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relationship with Statuses model
    public function status(){
        return $this->belongsTo(Status::class, 'statuses_id');
    }

    // relationship with ClientMinistry model
    public function clientMinistry(){
        return $this->belongsTo(ClientMinistry::class, 'client_ministry_id');
    }

    // relationship with Contractor model
    public function contractor(){
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    // retrieve parent project
    public function parentProject(){
        return $this->belongsTo(Project::class, 'parent_project_id');
    }

    //add relationship for pre-tender
    public function preTender(){
        return $this->hasOne(PreTender::class);
    }

    // get all child projects
    public function childProjects(){
        return $this->hasMany(Project::class, 'parent_project_id');
    }

    public function milestones(){
        return $this->belongsToMany(Milestone::class)->withPivot('completed', 'completed_at')->withTimestamps();
    }

    public function rkn(){
        return $this->belongsTo(RKN::class, 'rkn_id');
    }

    public function milestone(){
        return $this->belongsTo(Milestone::class, 'milestones_id');
    }

    public function contract(){
        return $this->hasOne(Contract::class);
    }

    public function tender(){
        return $this->hasOne(Tender::class);
    }
}
