<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Exports\LocationsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    /**
     * Display all locations with filtering, search, and pagination.
     */
    public function index(Request $request)
    {
        $query = Location::with('user:id,name,email')
            ->select([
                'id', 'user_id', 'name', 'description', 'latitude', 'longitude',
                'number_of_cots', 'early_juvenile', 'juvenile', 'sub_adult',
                'adult', 'late_adult', 'activity_type', 'observer_category',
                'municipality', 'barangay', 'date_of_sighting', 'time_of_sighting',
                'photo', 'created_at', 'updated_at',
            ]);

        $this->applyFilters($query, $request);

        $allowedSortFields = [
            'created_at', 'name', 'municipality', 'date_of_sighting',
            'number_of_cots', 'activity_type', 'observer_category',
        ];

        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query->orderBy(in_array($sortBy, $allowedSortFields) ? $sortBy : 'created_at', $sortOrder);

        if ($request->ajax() || $request->wantsJson()) {
            $locations = $query->paginate(50);

            return response()->json([
                'success'    => true,
                'data'       => $locations->items(),
                'pagination' => [
                    'current_page' => $locations->currentPage(),
                    'last_page'    => $locations->lastPage(),
                    'per_page'     => $locations->perPage(),
                    'total'        => $locations->total(),
                    'from'         => $locations->firstItem(),
                    'to'           => $locations->lastItem(),
                ],
                'stats' => $this->getLocationStats($request),
            ]);
        }

        $locations     = $query->get();
        $filterOptions = $this->getFilterOptions();
        $stats         = $this->getLocationStats($request);

        return view('admin.location', compact('locations', 'filterOptions', 'stats'));
    }

    /**
     * Store a new sighting (admin-submitted).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'nullable|string',
            'description'       => 'nullable|string',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'number_of_cots'    => 'nullable|string',
            'early_juvenile'    => 'nullable|integer',
            'juvenile'          => 'nullable|integer',
            'sub_adult'         => 'nullable|integer',
            'adult'             => 'nullable|integer',
            'late_adult'        => 'nullable|integer',
            'activity_type'     => 'nullable|string',
            'observer_category' => 'nullable|string',
            'municipality'      => 'nullable|string',
            'barangay'          => 'required|string',
            'photo.*'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'date_of_sighting'  => 'nullable|date',
            'time_of_sighting'  => 'nullable|date_format:H:i',
        ]);

        $photoPaths = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $photoPaths[] = $photo->storeAs(
                    'photos',
                    uniqid() . '.' . $photo->getClientOriginalExtension(),
                    'public'
                );
            }
        }

        Location::create([
            'user_id'           => Auth::id(),
            'name'              => $request->name,
            'description'       => $request->description,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'number_of_cots'    => $request->number_of_cots,
            'early_juvenile'    => $request->early_juvenile,
            'juvenile'          => $request->juvenile,
            'sub_adult'         => $request->sub_adult,
            'adult'             => $request->adult,
            'late_adult'        => $request->late_adult,
            'activity_type'     => $request->activity_type,
            'observer_category' => $request->observer_category,
            'municipality'      => $request->municipality,
            'barangay'          => $request->barangay,
            'date_of_sighting'  => $request->date_of_sighting,
            'time_of_sighting'  => $request->time_of_sighting,
            'photo'             => json_encode($photoPaths),
        ]);

        return redirect()->route('admin.location')->with('success', 'Location saved successfully.');
    }

    /**
     * Delete a location.
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if (! $location) {
            return response()->json(['message' => 'Location not found.'], 404);
        }

        $location->delete();

        return response()->json(['message' => 'Location deleted successfully.']);
    }

    /**
     * Show the report page with optional municipality filter.
     */
    public function report(Request $request)
    {
        $municipalities = Location::distinct()->pluck('municipality');

        $locations = Location::when($request->municipality, function ($query) use ($request) {
            $query->where('municipality', $request->municipality);
        })->paginate(10);

        return view('admin.report', compact('locations', 'municipalities'));
    }

    /**
     * Export locations to Excel.
     */
    public function export(Request $request)
    {
        $municipality = $request->input('municipality');

        $locations = Location::when($municipality, fn ($q) => $q->where('municipality', $municipality))
            ->get();

        $filename = $municipality
            ? 'report_' . strtolower($municipality) . '.xlsx'
            : 'report_all_locations.xlsx';

        return Excel::download(new LocationsExport($locations), $filename);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function applyFilters($query, Request $request): void
    {
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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('municipality', 'LIKE', "%{$search}%")
                  ->orWhere('barangay', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', fn ($uq) => $uq
                      ->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%"));
            });
        }
    }

    private function getFilterOptions(): array
    {
        $pluck = fn (string $col) => Location::distinct()
            ->whereNotNull($col)
            ->pluck($col)
            ->sort()
            ->values();

        return [
            'municipalities'     => $pluck('municipality'),
            'barangays'          => $pluck('barangay'),
            'activity_types'     => $pluck('activity_type'),
            'observer_categories'=> $pluck('observer_category'),
        ];
    }

    private function getLocationStats(Request $request = null): array
    {
        $query = Location::query();

        if ($request) {
            $this->applyFilters($query, $request);
        }

        return [
            'total_locations'      => (clone $query)->count(),
            'total_cots'           => (clone $query)->sum('number_of_cots') ?? 0,
            'unique_municipalities'=> (clone $query)->distinct('municipality')->count('municipality'),
            'recent_sightings'     => (clone $query)->where('created_at', '>=', now()->subDays(7))->count(),
            'by_municipality'      => (clone $query)->select('municipality', DB::raw('count(*) as count'), DB::raw('sum(number_of_cots) as total_cots'))
                ->whereNotNull('municipality')
                ->groupBy('municipality')
                ->orderByDesc(DB::raw('sum(number_of_cots)'))
                ->get(),
            'by_activity_type'     => (clone $query)->select('activity_type', DB::raw('count(*) as count'))
                ->whereNotNull('activity_type')
                ->groupBy('activity_type')
                ->orderByDesc('count')
                ->get(),
        ];
    }
}
