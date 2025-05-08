@extends("appLayout")

@section("title")
Home Page | {{ config('app.name') }}
@endsection

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}">{{ Auth::user()->name }} Dashboard</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home page') }}">Home</a>
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

@section("content")
<div class="container mt-4">
    <h3>Events</h3>

    @foreach($groupedEvents as $categoryName => $events)
    <h4 class="mt-4">Category | {{ $categoryName }}</h4>

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
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>

                    @if(in_array($event->id, $bookedEventIds))
                    <span class="badge bg-success">Booked</span>
                    @else
                    <form action="{{ route('tickets.book', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Book Now</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="alert alert-info col-12">
            No events found in this category.
        </div>
        @endforelse
    </div>
    @endforeach
    @endsection