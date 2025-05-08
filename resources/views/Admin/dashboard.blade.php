@extends('appLayout')
@section('title')
Admin Dashboard | {{ config('app.name') }}
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
<div class="container py-4">
    <h1 class="mb-4">Admin Dashboard</h1>
    <!-- Categories Table -->
    <h3>Categories</h3>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
    <table class="table table-bordered table-striped mb-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Events</h3>
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Create New Event</a>

    <div class="row">
        @forelse ($events as $event)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($event->image)
                <img src="{{ asset('event_images/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text"><strong>Date:</strong> {{ $event->date }}</p>
                    <p class="card-text"><strong>Venue:</strong> {{ $event->venue }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ $event->price }}</p>
                    <p class="card-text"><strong>Tickets:</strong> {{ $event->number_of_tickets }}</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info col-12">
            No events found.
        </div>
        @endforelse
    </div>
</div>
@endsection
