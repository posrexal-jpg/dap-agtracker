<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Municipality;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $totalSightings = Location::count();
        $userSightings = Location::where('user_id', $user->id)->count();
        $recentSightings = Location::orderBy('created_at', 'desc')->limit(5)->get();

        return view('user.dashboard', compact('totalSightings', 'userSightings', 'recentSightings'));
    }

    public function index()
    {
        $municipalities = Municipality::all();
        $locations = Location::orderBy('created_at', 'desc')->get();

        return view('user.index', compact('locations', 'municipalities'));
    }
}
