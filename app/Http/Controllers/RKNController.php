<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RKN;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RKNController extends Controller
{
    // show RKN
    public function showRKN()
    {
        $rkns = RKN::all();
        return view('pages.admin.rkn', compact('rkns'));
    }

    // update/create function
    public function store(Request $request)
    {
        // validate input
        $validated = $request->validate([
            'rknNum' => 'nullable|string',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
        ]);

        try {
            $rkn = RKN::create(
                $validated
            );

            return redirect()->route('pages.admin.rkn')->with('success', 'RKN details have been updated.');
        } catch (\Exception $e) {
            Log::error('RKN update failed: ', [
                'error' => $e->getMessage(),
                'input' => $validated
            ]);

            return back()->with('error', 'Failed to update RKN details. Please try again.');
        }
    }
}
