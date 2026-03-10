<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use LogsActivity;
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

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role_id'     => $request->role_id,
            'is_approved' => true, // Users created by admin are auto-approved
        ]);

        // Log the activity
        $this->logCreate($user, "Created new user: {$user->name} ({$user->email})");

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

        // Store old values for logging
        $oldValues = $user->only(['name', 'email']);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $oldValues['password'] = '[hidden]';
        }

        $user->save();

        // Log the activity
        $thisName = $user->name;
        $userEmail = $user->email;

        // Log before deleting
        $this->logDelete($user, "Deleted user: {$userName} ({$userEmail})");

        $user->logUpdate($user, $oldValues, "Updated user: {$user->name} ({$user->email})");

        return redirect()->route('admin.adduser')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.adduser')->with('success', 'User deleted successfully.');
    }

    /**
     * Approve a user account
     */// Log the activity
        $this->logApprove($user, "Approved user account: {$user->name} ({$user->email})");

        return redirect()->route('admin.adduser')->with('success', 'User approved successfully.');
    }

    /**
     * Reject/unapprove a user account
     */
    public function reject(User $user)
    {
        $user->is_approved = false;
        $user->save();

        // Log the activity
        $this->logReject($user, "Rejected/revoked approval for user: {$user->name} ({$user->email})");

        return redirect()->route('admin.adduser')->with('success', 'User approval revoked.');
    }

    /**
     * Toggle auto-approve for new users (bulk action)
     */
    public function approveAll()
    {
        $count = User::where('is_approved', false)->count();
        User::where('is_approved', false)->update(['is_approved' => true]);

        // Log the bulk activity
        $this->logActivity(
            'bulk_approve',
            "Bulk approved {$count} pending users"
        // Log the setting change
        $this->logActivity(
            'settings_change',
            $enabled 
                ? 'Enabled auto-approve for new users' 
                : 'Disabled auto-approve for new users',
            null,
            ['auto_approve_users' => !$enabled],
            ['auto_approve_users' => (bool)$enabled]
        );

        
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
}
