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
<<<<<<< HEAD
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 15);
=======
        $outbreakThreshold = (int) Setting::get('outbreak_threshold', 25);
>>>>>>> cfe5925bbedd2b2a05f4d904b6d23f3665016d7a

        return view('sightings', compact('locations', 'outbreakThreshold'));
    }
}
