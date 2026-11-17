@extends('layouts.admin')

@section('title', 'Activity Logs - COTS Tracker')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div><h1 class="h3 mb-1">Activity Logs</h1><p class="text-muted mb-0">Audit trail for report, user, and activity-type changes.</p></div>
        <form method="GET" class="d-flex gap-2"><select name="event" class="form-select"><option value="">All events</option>@foreach($events as $event)<option value="{{ $event }}" @selected(request('event') === $event)>{{ ucfirst($event) }}</option>@endforeach</select><button class="btn btn-outline-primary">Filter</button></form>
    </div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table table-striped align-middle mb-0">
        <thead><tr><th>Date and time</th><th>User</th><th>Event</th><th>Record</th><th>Description</th><th>IP address</th></tr></thead>
        <tbody>@forelse($logs as $log)<tr><td>{{ $log->created_at?->format('Y-m-d H:i:s') }}</td><td>{{ $log->user?->name ?? 'System' }}</td><td><span class="badge text-bg-secondary">{{ $log->event }}</span></td><td>{{ $log->subject_type }} #{{ $log->subject_id }}</td><td>{{ $log->description }}</td><td>{{ $log->ip_address }}</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">No activity has been recorded yet.</td></tr>@endforelse</tbody>
    </table></div></div>
    <div class="mt-3">{{ $logs->links() }}</div>
</div>
@endsection
