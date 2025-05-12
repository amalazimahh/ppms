<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenderRecommendation extends Model
{
    use HasFactory;

    protected $table = 'tender_recommendation';
    protected $fillable = [
        'tender_id',
        'toConsultant',
        'fromConsultant',
        'fromBPP',
        'toDG',
        'toLTK',
        'ltkApproval',
        'discLetter'
    ];
}
