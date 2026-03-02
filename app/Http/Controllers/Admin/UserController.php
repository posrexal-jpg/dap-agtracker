<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('admin.adduser', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.adduser', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('admin.adduser')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.adduser', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.adduser')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.adduser')->with('success', 'User deleted successfully.');
    }

    /**
     * Approve a user account
     */
    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.adduser')->with('success', 'User approved successfully.');
    }

    /**
     * Reject/unapprove a user account
     */
    public function reject(User $user)
    {
        $user->is_approved = false;
        $user->save();

        return redirect()->route('admin.adduser')->with('success', 'User approval revoked.');
    }

    /**
     * Toggle auto-approve for new users (bulk action)
     */
    public function approveAll()
    {
        User::where('is_approved', false)->update(['is_approved' => true]);

        return redirect()->route('admin.adduser')->with('success', 'All pending users approved successfully.');
    }
}
