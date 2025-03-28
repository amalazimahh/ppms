<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreTender extends Model
{
    use HasFactory;

    protected $table = 'pre_tender';
    protected $fillable = [
        'project_id',
        'rfpRfqNum',
        'rfqTitle',
        'rfqFee',
        'opened',
        'closed',
        'ext',
        'validity_ext',
        'jkmkkp_recomm',
        'jkmkkp_approval',
        'loa',
        'aac',
        'soilInv',
        'topoSurvey'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
