<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Public COTS sightings map page.
     */
    public function sightings()
    {
        $locations = Location::all();

        return view('sightings', compact('locations'));
    }
}
