@extends('appLayout')
@section('title')
Edit Event | {{ config('app.name') }}
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
        <h1>Edit Event</h1>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Event Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $event->price) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $event->category_name == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" name="image" class="form-control">
                @if ($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" width="100">
                @endif
            </div>

            <div class="form-group">
                <label for="number_of_tickets">Number of Tickets</label>
                <input type="number" name="number_of_tickets" class="form-control" value="{{ old('number_of_tickets', $event->number_of_tickets) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', $event->date) }}" required>
            </div>

            <div class="form-group">
                <label for="venue">Venue</label>
                <input type="text" name="venue" class="form-control" value="{{ old('venue', $event->venue) }}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Event</button>
        </form>
    </div>
@endsection
