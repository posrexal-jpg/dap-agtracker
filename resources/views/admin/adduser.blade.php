@extends('layouts.app')
@section('content')


<div class="container mt-4">
    <h1>Users</h1>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Create User
        </button>
            <div class="card">
                <h5 class="card-header">Users List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <!-- Edit Button with Icon -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                    <i class="bx bx-edit"></i> <!-- Replace this with your preferred icon -->
                                </button>
                                
                                <!-- Delete Form -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="bx bx-trash"></i> <!-- Replace this with your preferred icon -->
                                    </button>
                                </form>

                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">New Password (leave blank if no change)</label>
                                                        <input type="password" class="form-control" id="password" name="password">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update User</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('users.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>

                                        <!-- Role Dropdown -->
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role_id" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Add User Button -->
                                        <button type="submit" class="btn btn-primary">Add User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
</div>
@endsection
