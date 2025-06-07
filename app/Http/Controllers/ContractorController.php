<?php

namespace App\Http\Controllers;
use App\Models\Contractor;

use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = Contractor::all();
        return view('pages.admin.contractor', compact('contractors'));
    }

    // Store a new contractor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Contractor::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Contractor added successfully.');
    }

    // Update an existing contractor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $contractor = Contractor::findOrFail($id);
        $contractor->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Contractor updated successfully.');
    }

    // Delete a contractor
    public function destroy($id)
    {
        $contractor = Contractor::findOrFail($id);
        $contractor->delete();
        return redirect()->back()->with('success', 'Contractor deleted successfully.');
    }
}
