<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Models\Municipality;

class UserLocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $municipalities = Municipality::all();  // Retrieve all municipalities
        return view('user.index', compact('locations', 'municipalities'));  // Pass municipalities to the view
    }

    public function store(Request $request)
    {
        // Validate the request for multiple photos
        $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
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
        Location::create([
            'name' => $request->name ?? null,
            'description' => $request->description ?? null,
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
    
        // Redirect with a success message
        return redirect()->route('user.index')->with('success', 'Location saved successfully.');
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
}
