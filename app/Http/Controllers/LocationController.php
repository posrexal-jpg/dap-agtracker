<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LocationsExport;  // Make sure to import your export class
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class LocationController extends Controller
{
    /**
     * Display a listing of locations with advanced filtering and pagination
     */
    public function index(Request $request)
    {
        // Build the query with eager loading for better performance
        $query = Location::with('user:id,name,email')
            ->select([
                'id', 'user_id', 'name', 'description', 'latitude', 'longitude',
                'number_of_cots', 'early_juvenile', 'juvenile', 'sub_adult', 
                'adult', 'late_adult', 'activity_type', 'observer_category',
                'municipality', 'barangay', 'date_of_sighting', 'time_of_sighting',
                'photo', 'created_at', 'updated_at'
            ]);

        // Apply filters if provided
        if ($request->filled('municipality')) {
            $query->where('municipality', $request->municipality);
        }

        if ($request->filled('barangay')) {
            $query->where('barangay', $request->barangay);
        }

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('observer_category')) {
            $query->where('observer_category', $request->observer_category);
        }

        if ($request->filled('date_from')) {
            $query->where('date_of_sighting', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_of_sighting', '<=', $request->date_to);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('municipality', 'LIKE', "%{$search}%")
                  ->orWhere('barangay', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSortFields = [
            'created_at', 'name', 'municipality', 'date_of_sighting', 
            'number_of_cots', 'activity_type', 'observer_category'
        ];
        
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Get locations with pagination for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $locations = $query->paginate(50);
            
            return response()->json([
                'success' => true,
                'data' => $locations->items(),
                'pagination' => [
                    'current_page' => $locations->currentPage(),
                    'last_page' => $locations->lastPage(),
                    'per_page' => $locations->perPage(),
                    'total' => $locations->total(),
                    'from' => $locations->firstItem(),
                    'to' => $locations->lastItem(),
                ],
                'stats' => $this->getLocationStats($request)
            ]);
        }

        // For regular page load, get all locations for map display
        $locations = $query->get();
        
        // Get filter options for dropdowns
        $filterOptions = $this->getFilterOptions();
        
        // Get summary statistics
        $stats = $this->getLocationStats($request);

        return view('admin.location', compact('locations', 'filterOptions', 'stats'));
    }

    /**
     * Get filter options for dropdowns
     */
    private function getFilterOptions()
    {
        return [
            'municipalities' => Location::distinct()
                ->whereNotNull('municipality')
                ->pluck('municipality')
                ->sort()
                ->values(),
            'barangays' => Location::distinct()
                ->whereNotNull('barangay')
                ->pluck('barangay')
                ->sort()
                ->values(),
            'activity_types' => Location::distinct()
                ->whereNotNull('activity_type')
                ->pluck('activity_type')
                ->sort()
                ->values(),
            'observer_categories' => Location::distinct()
                ->whereNotNull('observer_category')
                ->pluck('observer_category')
                ->sort()
                ->values(),
        ];
    }

    /**
     * Get location statistics
     */
    private function getLocationStats(Request $request = null)
    {
        $query = Location::query();

        // Apply same filters as main query if request is provided
        if ($request) {
            if ($request->filled('municipality')) {
                $query->where('municipality', $request->municipality);
            }
            if ($request->filled('barangay')) {
                $query->where('barangay', $request->barangay);
            }
            if ($request->filled('activity_type')) {
                $query->where('activity_type', $request->activity_type);
            }
            if ($request->filled('observer_category')) {
                $query->where('observer_category', $request->observer_category);
            }
            if ($request->filled('date_from')) {
                $query->where('date_of_sighting', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->where('date_of_sighting', '<=', $request->date_to);
            }
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhere('municipality', 'LIKE', "%{$search}%")
                      ->orWhere('barangay', 'LIKE', "%{$search}%");
                });
            }
        }

        return [
            'total_locations' => $query->count(),
            'total_cots' => $query->sum('number_of_cots') ?? 0,
            'unique_municipalities' => $query->distinct()->count('municipality'),
            'recent_sightings' => $query->where('created_at', '>=', now()->subDays(7))->count(),
            'by_municipality' => $query->select('municipality', DB::raw('count(*) as count'), DB::raw('sum(number_of_cots) as total_cots'))
                ->whereNotNull('municipality')
                ->groupBy('municipality')
                ->orderBy(DB::raw('sum(number_of_cots)'), 'desc')
                ->get(),
            'by_activity_type' => $query->select('activity_type', DB::raw('count(*) as count'))
                ->whereNotNull('activity_type')
                ->groupBy('activity_type')
                ->orderBy('count', 'desc')
                ->get(),
        ];
    }

    public function sightings()
    {
        $locations = Location::all();
        return view('sightings', compact('locations'));
    }

    public function dashboard()
    {
        // Get the sum of number_of_cots by municipality
        $municipalityCots = Location::select('municipality', \DB::raw('sum(number_of_cots) as total_cots'))
                                    ->groupBy('municipality')
                                    ->get();
        
        // Calculate the total number of cots
        $totalCots = $municipalityCots->sum('total_cots');
        
        // Prepare data for the chart
        $municipalities = $municipalityCots->pluck('municipality');
        $totalCotsArray = $municipalityCots->pluck('total_cots');
        $percentages = $municipalityCots->map(function ($item) use ($totalCots) {
            return ($item->total_cots / $totalCots) * 100; // Calculate percentage
        });
        
        // Get the total number of users
        $userCount = \App\Models\User::count();
        
        // Pass $totalCots to the view
        return view('admin.index', compact('municipalities', 'totalCotsArray', 'percentages', 'userCount', 'totalCots'));
    }


    public function destroy($id)
    {
        $location = Location::find($id);

        if ($location) {
            $location->delete();
            return response()->json(['message' => 'Location deleted successfully.']);
        } else {
            return response()->json(['message' => 'Location not found.'], 404);
        }
    }

    // Method to generate the report
    public function report(Request $request)
    {
        // Get all unique municipalities
        $municipalities = Location::distinct()->pluck('municipality');

        // If a municipality is selected, filter by that municipality
        $locations = Location::when($request->municipality, function ($query) use ($request) {
            return $query->where('municipality', $request->municipality);
        })
        ->paginate(10);  // Limit to 10 rows per page

        return view('admin.report', compact('locations', 'municipalities'));
    }

    public function export(Request $request)
    {
        // Get the selected municipality from the request
        $municipality = $request->input('municipality');

        // Fetch the locations, optionally filtered by municipality
        $locations = Location::when($municipality, function ($query, $municipality) {
            return $query->where('municipality', $municipality);
        })->get();

        // Generate the filename based on the selected municipality
        $filename = $municipality ? 'report_' . strtolower($municipality) . '.xlsx' : 'report_all_locations.xlsx';

        // Export the filtered locations and download the file with the dynamic filename
        return Excel::download(new LocationsExport($locations), $filename);
    }

    // Inside DashboardController.php
    public function getDashboardData()
    {
        // Get the sum of number_of_cots by municipality
        $municipalityCots = Location::select('municipality', \DB::raw('sum(number_of_cots) as total_cots'))
                                    ->groupBy('municipality')
                                    ->get();

        // Calculate the total number of cots
        $totalCots = $municipalityCots->sum('total_cots');

        // Prepare data for the chart
        $municipalities = $municipalityCots->pluck('municipality');
        $totalCotsArray = $municipalityCots->pluck('total_cots');

        // Get the total number of users
        $userCount = \App\Models\User::count();

        // Return as JSON
        return response()->json([
            'userCount' => $userCount,
            'totalCots' => $totalCots,
            'municipalities' => $municipalities,
            'totalCotsArray' => $totalCotsArray,
        ]);
    }


}
