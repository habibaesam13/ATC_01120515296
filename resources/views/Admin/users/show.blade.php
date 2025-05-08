@extends('appLayout')

@section('title')
    {{ $data['user']->name }} | {{ config('app.name') }}
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- User Data -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>{{ $data['user']->name }}'s Profile</h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $data['user']->email }}</p>
                    <p><strong>Registered At:</strong> {{ $data['user']->created_at->format('d M Y') }}</p>
                    <!-- You can add more user fields as needed -->
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Booked Tickets</h5>
                </div>
                <div class="card-body">
                    @if ($data['tickets']->isEmpty())
                        <p>No tickets booked yet.</p>
                    @else
                        @foreach ($data['tickets'] as $eventId => $tickets)
                            <div class="mb-4">
                                <h6 class="text-uppercase font-weight-bold">Event: {{ $tickets->first()->event->name }}</h6>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Ticket ID</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Booked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>
                                                <td>
                                                    @if($ticket->status == 'booked')
                                                        <span class="badge bg-primary">Booked</span>
                                                    @else
                                                        <span class="badge bg-secondary">Available</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
