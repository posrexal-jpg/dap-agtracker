<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    // Show the form to create a new municipality
    public function create()
    {
        // Fetch all municipalities
    $municipalities = Municipality::all(); 

    // Pass the municipalities to the view
    return view('admin.municipal', compact('municipalities'));
    }

    // Store the new municipality in the database
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new municipality
        Municipality::create([
            'name' => $request->name,
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('admin.municipal.create')->with('success', 'Municipality added successfully!');
    }

    // Show a list of all municipalities
    // MunicipalityController.php
public function index()
{
    // Fetch all municipalities
    $municipalities = Municipality::all(); 

    // Pass the municipalities to the view
    return view('admin.municipal', compact('municipalities'));
}

public function destroy($id)
    {
        // Find the municipality by ID
        $municipality = Municipality::findOrFail($id);

        // Delete the municipality
        $municipality->delete();

        // Redirect back with a success message
        return redirect()->route('admin.municipal')->with('error', 'Municipality deleted successfully.');
    }



}
