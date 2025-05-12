<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalAward extends Model
{
    use HasFactory;

    protected $table = 'award';
    protected $fillable = [
        'tender_id',
        'loaIssued',
        'loa',
        'ladDay',
        'docPrep',
        'conSigned',
    ];
}
