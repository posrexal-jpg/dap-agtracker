<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Update authenticated user's profile (name, email)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.account')->with('success', 'Profile updated successfully.');
    }

    // Update authenticated user's password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('user.account')->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.account')->with('success', 'Password updated successfully.');
    }
}
