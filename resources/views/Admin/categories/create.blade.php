@extends('appLayout')
@section('title')
Add Category | {{ config('app.name') }}
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
                <!-- Add other navbar items as needed -->
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
    <div class="container">
        <h1>Create New Category</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display session error (e.g. "Category already exists") --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>
            <button type="submit" class="btn btn-success mt-3">Create Category</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3 ms-2">Back</a>
        </form>
    </div>
@endsection
