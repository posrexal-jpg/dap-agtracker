<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Import the Role model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Handle the form submission
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Ensure role_id is validated
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Use Hash for password
            'role_id' => $request->role_id, // Use the selected role
        ]);

        // Redirect to users list or any other page
        return redirect()->route('admin.adduser')->with('success', 'User created successfully.');
    }

    public function index()
    {
        $users = User::all(); // Fetch all users
        $roles = Role::all(); // Fetch all roles
        return view('admin.adduser', compact('users', 'roles')); // Pass roles to the view
    }
    
    public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('admin.adduser')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.adduser')->with('success', 'User updated successfully.');
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles from the database
        return view('admin.adduser', compact('roles')); // Return the view with roles data
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Fetch all roles
        return view('admin.adduser', compact('user', 'roles')); // Return the view with user and roles data
    }
}
