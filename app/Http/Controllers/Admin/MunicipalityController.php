<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $municipalities = Municipality::orderBy('name')->get();

        return view('admin.municipal', compact('municipalities'));
    }

    public function create()
    {
        $municipalities = Municipality::orderBy('name')->get();

        return view('admin.municipal', compact('municipalities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:municipalities,name',
        ]);

        $municipality = Municipality::create(['name' => $request->name]);

        // Log the activity
        $this->logCreate($municipality, "Added new municipality: {$municipality->name}");

        return redirect()->route('admin.municipal.create')->with('success', 'Municipality added successfully.');
    }

    public function destroy($id)
    {
        $municipality = Municipality::findOrFail($id);
        $municipalityName = $municipality->name;

        // Log before deleting
        $this->logDelete($municipality, "Deleted municipality: {$municipalityName}");

        $municipality->delete();

        return redirect()->route('admin.municipal')->with('success', 'Municipality deleted successfully.');
    }
}
