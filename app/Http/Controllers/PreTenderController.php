<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreTender;

class PreTenderController extends Controller
{
    public function store(Request $request, $project_id){
        $validated = $request->validate([
            'rfpRfqNum'=>'nullable|string',
            'rfqTitle'=>'nullable|string',
            'rfqFee'=>'nullable|numeric',
            'opened'=>'nullable|date',
            'closed'=>'nullable|date',
            'ext'=>'nullable|date',
            'validity_ext'=>'nullable|date',
            'jkmkkp_recomm'=>'nullable|date',
            'jkmkkp_approval'=>'nullable|date',
            'loa'=>'nullable|date',
            'aac'=>'nullable|date',
        ]);

        PreTender::updateOrCreate(
            ['project_id' => $project_id],
            $validated
        );

        return redirect()->back()->with('success', 'Pre-Tender details saved successfully!');
    }
}
