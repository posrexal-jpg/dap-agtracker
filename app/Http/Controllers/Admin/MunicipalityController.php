<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
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

        Municipality::create(['name' => $request->name]);

        return redirect()->route('admin.municipal.create')->with('success', 'Municipality added successfully.');
    }

    public function destroy($id)
    {
        Municipality::findOrFail($id)->delete();

        return redirect()->route('admin.municipal')->with('success', 'Municipality deleted successfully.');
    }
}
