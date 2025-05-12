<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    protected $table = 'tender';
    protected $fillable = [
        'project_id',
        'confirmFund',
        'costAmt',
        'costDate',
        'tenderNum',
        'openedFirst',
        'openedSec',
        'closed',
        'ext',
        'validity',
        'validity_ext',
        'cancelled'
    ];
}
