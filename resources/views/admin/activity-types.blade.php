@extends('layouts.admin')

@section('title', 'Activity Types - COTS Tracker')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Activity Types</h1>
            <p class="text-muted mb-0">Manage the choices synchronized to the mobile app for online and offline reporting.</p>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.activity-types.store') }}" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-7">
                    <label class="form-label" for="activity-name">Activity name</label>
                    <input id="activity-name" name="name" class="form-control" maxlength="100" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="activity-order">Order</label>
                    <input id="activity-order" name="sort_order" type="number" min="0" class="form-control">
                </div>
                <div class="col-md-3"><button class="btn btn-primary w-100">Add activity type</button></div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead><tr><th>Name</th><th style="width:110px">Order</th><th style="width:110px">Active</th><th style="width:190px">Actions</th></tr></thead>
                <tbody>
                @foreach($activityTypes as $activityType)
                    <tr>
                        <td>
                            <form id="activity-update-{{ $activityType->id }}" method="POST" action="{{ route('admin.activity-types.update', $activityType) }}">@csrf @method('PUT')</form>
                            <input form="activity-update-{{ $activityType->id }}" name="name" value="{{ $activityType->name }}" class="form-control" required>
                        </td>
                        <td><input form="activity-update-{{ $activityType->id }}" name="sort_order" type="number" min="0" value="{{ $activityType->sort_order }}" class="form-control" required></td>
                        <td><div class="form-check form-switch"><input form="activity-update-{{ $activityType->id }}" class="form-check-input" type="checkbox" name="is_active" value="1" @checked($activityType->is_active)><label class="form-check-label">Active</label></div></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button form="activity-update-{{ $activityType->id }}" class="btn btn-sm btn-outline-primary">Save</button>
                                <form method="POST" action="{{ route('admin.activity-types.destroy', $activityType) }}" onsubmit="return confirm('Remove this choice? Existing reports will be retained.')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Remove</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
