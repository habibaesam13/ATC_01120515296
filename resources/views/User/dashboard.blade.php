@extends("appLayout")

@section("title")
{{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }} Dashboard | {{ config('app.name') }}
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
    <div class="card" style="width: 25rem;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Welcome, {{ $user->name }}</h5>

            <h6 class="card-subtitle mb-2 text-muted text-center">Your Information</h6>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Joined:</strong> {{ $user->created_at->format('d-m-Y') }}</li>
                <!-- Add any additional user data here -->
            </ul>

            <h6 class="card-subtitle mb-2 text-muted text-center">Your Booked Tickets</h6>
            @if ($tickets->isEmpty())
            <p class="text-center">You haven't booked any tickets yet.</p>
            @else
            <div class="list-group">
                @foreach ($tickets as $ticket)
                <div class="list-group-item">
                    <strong>Event:</strong> {{ $ticket->event->name }} <br>
                    <strong>Booked At:</strong> {{ $ticket->created_at->format('d-m-Y') }} <br>
                        <form action="{{ route('tickets.unbook', $ticket->event->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Unbook Ticket</button>
                        </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection