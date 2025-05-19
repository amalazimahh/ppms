<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'roles_id' => 'required|exists:roles,id',
        ]);
        $user->roles_id = $request->input('roles_id');
        $user->save();

        return redirect()->back()->with('status', 'Role assigned successfully!');
    }
}
