<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function create() {
        $statuses = Status::all();

        return view('pages.admin.forms.basicdetails','pages.project_manager.forms.basicdetails', compact('statuses'));
    }
}
