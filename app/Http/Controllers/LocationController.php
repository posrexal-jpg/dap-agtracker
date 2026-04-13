<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Setting;

class LocationController extends Controller
{
    /**
     * Public COTS sightings map page.
     */
    public function sightings()
    {
        $locations = Location::all();
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 15);

        return view('sightings', compact('locations', 'outbreakThreshold'));
    }
}
