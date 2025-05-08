@extends('appLayout')

@section('title')
Register | {{ config('app.name') }}
@endsection

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <h4 class="mb-4 text-center">Register</h4>
        <form action="{{ route('auth.register') }}" method="POST">
            @csrf

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
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
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
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

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</div>
@endsection