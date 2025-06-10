<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    use HasFactory;

    protected $table = 'project_team';

    protected $fillable =
    [
        'project_id',
        'officer_in_charge',
        'architect_id',
        'mechanical_electrical_id',
        'civil_structural_id',
        'quantity_surveyor_id',
        'others_id'
    ];

    // relationships
    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function officerInCharge(){
        return $this->belongsTo(User::class, 'officer_in_charge');
    }


    public function architect(){
        return $this->belongsTo(Architect::class, 'architect_id');
    }

    public function mechanicalElectrical(){
        return $this->belongsTo(MechanicalElectrical::class, 'mechanical_electrical_id');
    }

    public function civilStructural(){
        return $this->belongsTo(CivilStructural::class, 'civil_structural_id');
    }

    public function quantitySurveyor(){
        return $this->belongsTo(QuantitySurveyor::class, 'quantity_surveyor_id');
    }

    public function others(){
        return $this->belongsTo(Others::class, 'others_id');
    }
}
