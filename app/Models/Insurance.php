<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'insurance';
    protected $fillable = [
        'contract_id',
        'insType',
        'insIssued',
        'insExpiry',
        'insExt'
    ];
}
