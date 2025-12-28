<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $municipalityCots = Location::select(
                'municipality',
                DB::raw('SUM(number_of_cots) as total_cots')
            )
            ->groupBy('municipality')
            ->get();

        $totalCots = $municipalityCots->sum('total_cots');
        $userCount = User::count();
        $locationCount = Location::count();

        $municipalities = $municipalityCots->pluck('municipality')->toArray();
        $totalCotsArray = $municipalityCots->pluck('total_cots')->toArray();

        return view('admin.index', compact(
            'municipalities',
            'totalCotsArray',
            'userCount',
            'totalCots',
            'locationCount'
        ));
    }
}