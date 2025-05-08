@extends('appLayout')
@section('title')
{{ $user->name }} Edit | {{ config('app.name') }}
@endsection

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6"> {{-- Adjust width as needed --}}
        <h1 class="text-center mb-4">Edit User</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- To specify that this is an update request --}}

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}" {{-- Default to current user's name --}}
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}" {{-- Default to current user's email --}}
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field (optional) -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control @error('pass') is-invalid @enderror"
                        id="password"
                        name="password"
                        required>
                    <button type="button" id="toggle-password" class="btn btn-outline-secondary">
                        <i class="bi bi-eye-slash" id="toggle-password-icon"></i>
                    </button>
                </div>
                @error('pass')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

            </div>

            <button type="submit" class="btn btn-success w-100">Update User</button>
        </form>
    </div>
</div>
@endsection