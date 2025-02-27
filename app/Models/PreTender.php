<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasFactory;

class PreTender extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id', 'rfpRfqNum', 'rfqTitle', 'rfqFee', 'opened', 'closed',
        'ext', 'validity_ext', 'jkmkkp_recomm', 'jkmkkp_approval',
        'loa', 'aac'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
