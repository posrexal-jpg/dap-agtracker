@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Municipalities</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Button to trigger modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#municipalityModal">Add Municipality</button>

        <!-- Municipalities Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($municipalities as $municipality)
                <tr>
                    <td>{{ $municipality->name }}</td>
                    <td>
                    <form action="{{  route('admin.municipal.destroy', $municipality->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                <i class="bx bx-trash"></i> <!-- Replace this with your preferred icon -->
                            </button>
                    </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="municipalityModal" tabindex="-1" aria-labelledby="municipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="municipalityModalLabel">Create Municipality</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.municipal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Municipality Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Municipality</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Bootstrap JS (if not already included in your layout) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
