<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount     = User::count();
        $locationCount = Location::count();
        $totalCots     = Location::sum('number_of_cots');

        // Municipality data for pie chart
        $municipalityCots = Location::select(
                'municipality',
                DB::raw('SUM(number_of_cots) as total_cots'),
                DB::raw('COUNT(*) as sighting_count')
            )
            ->whereNotNull('municipality')
            ->groupBy('municipality')
            ->orderByDesc(DB::raw('SUM(number_of_cots)'))
            ->get();

        // Recent activity (last 7 days)
        $recentSightings = Location::where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Activity type distribution
        $activityTypes = Location::select('activity_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('activity_type')
            ->groupBy('activity_type')
            ->orderByDesc('count')
            ->get();

        // Observer category distribution
        $observerCategories = Location::select('observer_category', DB::raw('COUNT(*) as count'))
            ->whereNotNull('observer_category')
            ->groupBy('observer_category')
            ->orderByDesc('count')
            ->get();

        // Monthly trends (last 6 months)
        $monthlyData = Location::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as sightings'),
                DB::raw('SUM(number_of_cots) as total_cots')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // COTS size distribution
        $cotsSizes = [
            'early_juvenile' => Location::sum('early_juvenile'),
            'juvenile'       => Location::sum('juvenile'),
            'sub_adult'      => Location::sum('sub_adult'),
            'adult'          => Location::sum('adult'),
            'late_adult'     => Location::sum('late_adult'),
        ];

        // Top barangays
        $topBarangays = Location::select('barangay', DB::raw('COUNT(*) as count'))
            ->whereNotNull('barangay')
            ->groupBy('barangay')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::orderByDesc('created_at')->take(3)->get();

        return view('admin.index', [
            'userCount'       => $userCount,
            'locationCount'   => $locationCount,
            'totalCots'       => $totalCots,
            'municipalities'  => $municipalityCots->pluck('municipality')->toArray(),
            'totalCotsArray'  => $municipalityCots->pluck('total_cots')->toArray(),
            'sightingCounts'  => $municipalityCots->pluck('sighting_count')->toArray(),
            'recentSightings' => $recentSightings,
            'activityLabels'  => $activityTypes->pluck('activity_type')->toArray(),
            'activityCounts'  => $activityTypes->pluck('count')->toArray(),
            'observerLabels'  => $observerCategories->pluck('observer_category')->toArray(),
            'observerCounts'  => $observerCategories->pluck('count')->toArray(),
            'monthlyLabels'   => $monthlyData->pluck('month')->toArray(),
            'monthlySightings'=> $monthlyData->pluck('sightings')->toArray(),
            'monthlyCots'     => $monthlyData->pluck('total_cots')->toArray(),
            'cotsSizes'       => $cotsSizes,
            'topBarangays'    => $topBarangays,
            'recentUsers'     => $recentUsers,
        ]);
    }

    /**
     * Returns JSON summary data used by dashboard charts.
     */
    public function dashboardData()
    {
        $municipalityCots = Location::select(
                'municipality',
                DB::raw('SUM(number_of_cots) as total_cots')
            )
            ->groupBy('municipality')
            ->get();

        return response()->json([
            'userCount'      => User::count(),
            'totalCots'      => $municipalityCots->sum('total_cots'),
            'municipalities' => $municipalityCots->pluck('municipality'),
            'totalCotsArray' => $municipalityCots->pluck('total_cots'),
        ]);
    }
}
