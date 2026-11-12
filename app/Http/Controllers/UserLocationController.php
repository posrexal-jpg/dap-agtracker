<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Municipality;
use App\Models\Setting;

class UserLocationController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        $userLocations = Location::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $municipalities = Municipality::all();
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 25);

        return view('user.account', compact('userLocations', 'municipalities', 'outbreakThreshold'));
    }

    public function index()
    {
        $municipalities = Municipality::all();
        $locations = Location::orderBy('created_at', 'desc')->get();
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 25);

        return view('user.index', compact('locations', 'municipalities', 'outbreakThreshold'));
    }

    public function create()
    {
        $municipalities = Municipality::all();
        return view('user.create', compact('municipalities'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request for multiple photos
            $validated = $request->validate([
                'name' => 'nullable|string',
                'language' => 'nullable|string',
                'description' => 'nullable|string',
                'location_name' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'number_of_cots' => 'nullable|string',
                'early_juvenile' => 'nullable|integer',
                'juvenile' => 'nullable|integer',
                'sub_adult' => 'nullable|integer',
                'adult' => 'nullable|integer',
                'late_adult' => 'nullable|integer',
                'activity_type' => 'nullable|string',
                'activity_type_other' => 'nullable|string|max:255',
                'observer_category' => 'nullable|string',
                'survey_status' => 'nullable|in:Systematic survey,Opportunistic sighting',
                'municipality' => 'nullable|string',
                'barangay' => 'required|string',
                'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Handle multiple images
                'date_of_sighting' => 'nullable|date',
                'time_of_sighting' => 'nullable|date_format:H:i',
                'observation_start_time' => 'nullable|date_format:H:i|required_with:observation_end_time',
                'observation_end_time' => 'nullable|date_format:H:i|required_with:observation_start_time|after_or_equal:observation_start_time',
                'transect_length_m' => 'nullable|numeric|min:0',
                'transect_width_m' => 'nullable|numeric|min:0',
                'surveyed_area_m2' => 'nullable|numeric|min:0',
                'depth_m' => 'nullable|numeric|min:0',
                'water_visibility_m' => 'nullable|numeric|min:0',
                'weather_sea_condition' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON response for AJAX requests with validation errors
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    
        try {
            // Handle multiple photo uploads
            $photoPaths = [];
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $photoPath = $photo->storeAs(
                        'photos', 
                        uniqid() . '.' . $photo->getClientOriginalExtension(), 
                        'public'
                    );
                    $photoPaths[] = $photoPath; // Add each photo path to the array
                }
            }
        
            // Create a new location using the request data
            $location = Location::create([
                'user_id' => Auth::id(),
                'name' => $request->name ?? null,
                'language' => $request->language ?? 'en',
                'description' => $request->description ?? null,
                'location_name' => $request->location_name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'number_of_cots' => $request->number_of_cots,
                'early_juvenile' => $request->early_juvenile ?? null,
                'juvenile' => $request->juvenile ?? null,
                'sub_adult' => $request->sub_adult ?? null,
                'adult' => $request->adult ?? null,
                'late_adult' => $request->late_adult ?? null,
                'activity_type' => $request->activity_type,
                'activity_type_other' => $request->activity_type_other,
                'observer_category' => $request->observer_category,
                'survey_status' => $request->survey_status,
                'municipality' => $request->municipality,
                'barangay' => $request->barangay,
                'date_of_sighting' => $request->date_of_sighting,
                'time_of_sighting' => $request->time_of_sighting,
                'observation_start_time' => $request->observation_start_time,
                'observation_end_time' => $request->observation_end_time,
                'observation_duration_minutes' => $this->durationMinutes($request->observation_start_time, $request->observation_end_time),
                'transect_length_m' => $request->transect_length_m,
                'transect_width_m' => $request->transect_width_m,
                'surveyed_area_m2' => $request->surveyed_area_m2 ?: ($request->transect_length_m && $request->transect_width_m ? $request->transect_length_m * $request->transect_width_m : null),
                'depth_m' => $request->depth_m,
                'water_visibility_m' => $request->water_visibility_m,
                'weather_sea_condition' => $request->weather_sea_condition,
                'photo' => json_encode($photoPaths), // Store the array of photo paths as a JSON string
            ]);

            // Create notification for admins
            $userName = $request->name ?? Auth::user()->name ?? 'A user';
            $cotsCount = $request->number_of_cots ?? 'Unknown';
            
            Notification::create([
                'type' => 'new_sighting',
                'location_id' => $location->id,
                'user_id' => Auth::id(),
                'title' => 'New COTS Sighting Reported',
                'message' => "{$userName} reported {$cotsCount} COTS at {$request->location_name}, {$request->municipality}, {$request->barangay}",
                'is_read' => false,
            ]);
        
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Location saved successfully.',
                    'location' => $location
                ], 200);
            }
            
            // Redirect with a success message for regular form submissions
            return redirect()->route('user.sightings-map')->with('success', 'Location saved successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Failed to save location: ' . $e->getMessage());
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save location: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to save location. Please try again.');
        }
    }

    public function destroy($id)
    {
        $location = Location::where('id', $id)->where('user_id', Auth::id())->first();

        if ($location) {
            $location->delete();
            return response()->json(['message' => 'Location deleted successfully.']);
        } else {
            return response()->json(['message' => 'Location not found or access denied.'], 404);
        }
    }

    /**
     * Sync offline locations when user comes back online
     */
    public function syncLocations(Request $request)
    {
        try {
            $locations = $request->input('locations', []);

            if (empty($locations)) {
                return response()->json([
                    'success' => true,
                    'message' => 'No locations to sync',
                    'synced_count' => 0
                ]);
            }

            $syncedCount = 0;
            $errors = [];

            foreach ($locations as $locationData) {
                try {
                    // Validate the location data
                    $validatedData = validator($locationData, [
                        'name' => 'nullable|string',
                        'language' => 'nullable|string',
                        'description' => 'nullable|string',
                        'location_name' => 'nullable|string',
                        'latitude' => 'required|numeric',
                        'longitude' => 'required|numeric',
                        'number_of_cots' => 'nullable|string',
                        'early_juvenile' => 'nullable|integer',
                        'juvenile' => 'nullable|integer',
                        'sub_adult' => 'nullable|integer',
                        'adult' => 'nullable|integer',
                        'late_adult' => 'nullable|integer',
                        'activity_type' => 'nullable|string',
                        'activity_type_other' => 'nullable|string|max:255',
                        'observer_category' => 'nullable|string',
                        'survey_status' => 'nullable|in:Systematic survey,Opportunistic sighting',
                        'municipality' => 'nullable|string',
                        'barangay' => 'required|string',
                        'date_of_sighting' => 'nullable|date',
                        'time_of_sighting' => 'nullable|date_format:H:i',
                        'observation_start_time' => 'nullable|date_format:H:i',
                        'observation_end_time' => 'nullable|date_format:H:i|after_or_equal:observation_start_time',
                        'observation_duration_minutes' => 'nullable|integer|min:0|max:1440',
                        'transect_length_m' => 'nullable|numeric|min:0',
                        'transect_width_m' => 'nullable|numeric|min:0',
                        'surveyed_area_m2' => 'nullable|numeric|min:0',
                        'depth_m' => 'nullable|numeric|min:0',
                        'water_visibility_m' => 'nullable|numeric|min:0',
                        'weather_sea_condition' => 'nullable|string|max:255',
                    ])->validate();

                    // Create the location
                    Location::create($validatedData);
                    $syncedCount++;

                } catch (\Exception $e) {
                    $errors[] = 'Failed to sync location: ' . $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Synced {$syncedCount} locations successfully",
                'synced_count' => $syncedCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function durationMinutes(?string $start, ?string $end): ?int
    {
        if (! $start || ! $end) {
            return null;
        }

        [$startHour, $startMinute] = array_map('intval', explode(':', $start));
        [$endHour, $endMinute] = array_map('intval', explode(':', $end));

        return ($endHour * 60 + $endMinute) - ($startHour * 60 + $startMinute);
    }
}
