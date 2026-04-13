<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('role')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();

        return view('admin.adduser', compact('users', 'roles', 'search'));
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
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role_id'     => $request->role_id,
            'is_approved' => true, // Users created by admin are auto-approved
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

    /**
     * Toggle auto-approve setting
     */
    public function toggleAutoApprove(Request $request)
    {
        $enabled = $request->input('enabled', 0);
        Setting::set('auto_approve_users', $enabled);

        $message = $enabled 
            ? 'Auto-approve enabled. New users will be automatically approved.' 
            : 'Auto-approve disabled. New users will require manual approval.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'enabled' => (bool) $enabled
        ]);
    }

    /**
     * Update the outbreak COTS count threshold
     */
    public function updateOutbreakThreshold(Request $request)
    {
        $request->validate([
            'threshold' => 'required|integer|min:1|max:9999',
        ]);

        Setting::set('outbreak_threshold', $request->input('threshold'));

        return response()->json([
            'success' => true,
            'message' => 'Outbreak threshold updated to ' . $request->input('threshold') . ' COTS.',
            'threshold' => (int) $request->input('threshold'),
        ]);
    }
}
