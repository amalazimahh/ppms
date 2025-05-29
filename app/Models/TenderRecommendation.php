<?php

namespace App\Models;

use App\Models\Tender;
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

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
