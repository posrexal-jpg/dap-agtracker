<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user:id,name,email')
            ->when($request->filled('event'), fn ($query) => $query->where('event', $request->event))
            ->latest()
            ->paginate(50)
            ->withQueryString();
        $events = ActivityLog::distinct()->orderBy('event')->pluck('event');

        return view('admin.activity-logs', compact('logs', 'events'));
    }
}
