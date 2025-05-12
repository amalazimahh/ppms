<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankerGuarantee extends Model
{
    use HasFactory;

    protected $table = 'banker_guarantee';
    protected $fillable = [
        'contract_id',
        'bgAmt',
        'bgIssued',
        'bgExpiry',
        'bgExt'
    ];

    public function contract(){
        return $this->belongsTo(Contract::class);
    }
}
