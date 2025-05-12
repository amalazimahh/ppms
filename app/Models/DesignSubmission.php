<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DesignSubmission extends Model
{
    use HasFactory;

    protected $table = 'design_submission';
    protected $fillable = [
        'project_id',
        'kom',
        'conAppr',
        'designRev',
        'detailedRev'
    ];
}
