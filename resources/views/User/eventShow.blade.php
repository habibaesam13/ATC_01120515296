@extends('appLayout')
@section('title')
{{ $event->name }} Event | {{ config('app.name') }}
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
@section('content')
<div class="container py-4">
    <h1>{{ $event->name }}</h1>
    <div class="card mb-4">
        @if($event->image)
        <img src="{{ asset('event_images/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 300px; object-fit: cover;">
        @endif
        <div class="card-body">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Price:</strong> ${{ $event->price }}</p>
            <p><strong>Date:</strong> {{ $event->date }}</p>
            <p><strong>Venue:</strong> {{ $event->venue }}</p>
            <p><strong>Tickets:</strong> {{ $event->number_of_tickets }}</p>
            <h3>Tickets you booked: {{ $userTicketCount }}</h3>
            <h3>Tickets available: {{ $availableTickets }}</h3>
            <form action="{{ route('tickets.book', $event->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary">Book Ticket</button>
            </form>

            <form action="{{ route('tickets.unbook', $event->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-warning">Unbook Ticket</button>
            </form>

            <form action="{{ route('tickets.unbookAll', $event->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Unbook All</button>
            </form>

        </div>
    </div>
</div>
@endsection