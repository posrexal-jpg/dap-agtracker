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
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 15);

        return view('user.account', compact('userLocations', 'municipalities', 'outbreakThreshold'));
    }

    public function index()
    {
        $municipalities = Municipality::all();
        $locations = Location::orderBy('created_at', 'desc')->get();
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 15);

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
                'observer_category' => 'nullable|string',
                'municipality' => 'nullable|string',
                'barangay' => 'required|string',
                'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Handle multiple images
                'date_of_sighting' => 'nullable|date',
                'time_of_sighting' => 'nullable|date_format:H:i',
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
                'observer_category' => $request->observer_category,
                'municipality' => $request->municipality,
                'barangay' => $request->barangay,
                'date_of_sighting' => $request->date_of_sighting,
                'time_of_sighting' => $request->time_of_sighting,
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
                        'observer_category' => 'nullable|string',
                        'municipality' => 'nullable|string',
                        'barangay' => 'required|string',
                        'date_of_sighting' => 'nullable|date',
                        'time_of_sighting' => 'nullable|date_format:H:i',
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
}
