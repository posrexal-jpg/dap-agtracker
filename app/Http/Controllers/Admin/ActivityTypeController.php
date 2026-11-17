<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityTypeController extends Controller
{
    public function index()
    {
        $activityTypes = ActivityType::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.activity-types', compact('activityTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:activity_types,name'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] ??= (ActivityType::max('sort_order') ?? 0) + 1;
        ActivityType::create($data);

        return back()->with('success', 'Activity type added.');
    }

    public function update(Request $request, ActivityType $activityType)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('activity_types')->ignore($activityType)],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $activityType->update($data);

        return back()->with('success', 'Activity type updated.');
    }

    public function destroy(ActivityType $activityType)
    {
        $activityType->delete();

        return back()->with('success', 'Activity type removed. Existing reports were retained.');
    }
}
