<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth
use Illuminate\Support\Facades\Session; // Import the Session facade
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'signOut', 'dashboard'
        ]);
    }
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle the custom login request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            return redirect($this->redirectTo());
        }

        return redirect("/login")->withErrors(['email' => 'Invalid login credentials. Please check your email and password.']);
    }

    /**
     * Redirect users based on their role.
     *
     * @return string
     */
    public function redirectTo()
    {
        $userroleid = Auth::user()->role_id;
        switch ($userroleid) {
            case 1:
                return '/admin';
            case 2:
                return '/user/index';
            default:
                return '/login'; // Fallback if no role matches
        }
    }

    /**
     * Redirect to Google's OAuth page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['oauth' => 'Google authentication failed.']);
        }

        if (! $googleUser || ! $googleUser->getEmail()) {
            return redirect('/login')->withErrors(['oauth' => 'Unable to retrieve Google account email.']);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->google_id = $googleUser->getId();
            $user->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(uniqid('google_', true)),
                'role_id' => 2,
            ]);
        }

        Auth::login($user);

        return redirect($this->redirectTo());
    }

    /**
     * Log the user out and redirect to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}