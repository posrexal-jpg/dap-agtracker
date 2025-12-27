<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth
use Illuminate\Support\Facades\Session; // Import the Session facade

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

        return redirect("/login")->withErrors(['email' => 'Login details are not valid']);
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
                return '/admin/index';
            case 2:
                return '/user/index';
            default:
                return '/login'; // Fallback if no role matches
        }
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