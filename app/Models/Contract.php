<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contract';
    protected $fillable = [
        'project_id',
        'contractor_id',
        'contractNum',
        'start',
        'end',
        'period',
        'sum',
        'revSum',
        'lad',
        'totalLad',
        'cnc',
        'revComp',
        'actualComp',
        'cpc',
        'edlp',
        'cmgd',
        'lsk',
        'penAmt',
        'retAmt',
        'statDec'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
