@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">
                    <i class="bx bx-user-circle me-3 text-primary"></i>
                    Manage Users
                </h1>
                <p class="page-subtitle">Add, edit, and manage system users with ease</p>
            </div>
            <div class="page-actions">
                <button type="button" class="btn btn-primary" onclick="openAddUserModal()">
                    <i class="bx bx-plus me-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Users List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $user->role->role_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" title="Edit User">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit User Modal for each user -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit User: {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name-{{ $user->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name-{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email-{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password-{{ $user->id }}" class="form-label">New Password (leave blank if no change)</label>
                                                    <input type="password" class="form-control" id="password-{{ $user->id }}" name="password">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password_confirmation-{{ $user->id }}" class="form-label">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation-{{ $user->id }}" name="password_confirmation">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update User</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role" name="role_id" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Add User Button -->
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function openAddUserModal() {
    const modalElement = document.getElementById('addUserModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}

// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const form = document.querySelector('#addUserModal form');

    // Real-time password confirmation validation
    passwordConfirmation.addEventListener('input', function() {
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Passwords do not match');
            passwordConfirmation.classList.add('is-invalid');
        } else {
            passwordConfirmation.setCustomValidity('');
            passwordConfirmation.classList.remove('is-invalid');
            passwordConfirmation.classList.add('is-valid');
        }
    });

    // Password strength validation
    password.addEventListener('input', function() {
        const value = password.value;
        if (value.length < 8) {
            password.setCustomValidity('Password must be at least 8 characters long');
            password.classList.add('is-invalid');
        } else {
            password.setCustomValidity('');
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
        }

        // Re-validate confirmation if password changes
        if (passwordConfirmation.value) {
            passwordConfirmation.dispatchEvent(new Event('input'));
        }
    });

    // Email validation
    const email = document.getElementById('email');
    email.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            email.setCustomValidity('Please enter a valid email address');
            email.classList.add('is-invalid');
        } else {
            email.setCustomValidity('');
            email.classList.remove('is-invalid');
            email.classList.add('is-valid');
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        // Check if passwords match
        if (password.value !== passwordConfirmation.value) {
            e.preventDefault();
            passwordConfirmation.setCustomValidity('Passwords do not match');
            passwordConfirmation.classList.add('is-invalid');
            passwordConfirmation.focus();
            return false;
        }

        // Check password length
        if (password.value.length < 8) {
            e.preventDefault();
            password.setCustomValidity('Password must be at least 8 characters long');
            password.classList.add('is-invalid');
            password.focus();
            return false;
        }

        // Check email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            e.preventDefault();
            email.setCustomValidity('Please enter a valid email address');
            email.classList.add('is-invalid');
            email.focus();
            return false;
        }
    });

    // Clear validation on modal close
    const modal = document.getElementById('addUserModal');
    modal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        // Clear validation classes
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
            input.setCustomValidity('');
        });
    });

    // Reopen modal if there are validation errors
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openAddUserModal();
        });
    @endif
});
</script>
