@extends('appLayout') 
@section('title')
Add Event | {{ config('app.name') }}
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
    <h1>Create Event</h1>

    {{-- Display global validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Event Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required min="0" step="0.01">
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="image">Event Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="number_of_tickets">Number of Tickets</label>
            <input type="number" name="number_of_tickets" class="form-control @error('number_of_tickets') is-invalid @enderror" value="{{ old('number_of_tickets') }}" required min="1">
            @error('number_of_tickets') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="venue">Venue</label>
            <input type="text" name="venue" class="form-control @error('venue') is-invalid @enderror" value="{{ old('venue') }}" required>
            @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create Event</button>
    </form>
</div>
@endsection
