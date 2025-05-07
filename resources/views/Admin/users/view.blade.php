@extends('appLayout')

@section('content')
    <div class="container">
        <h1>User Details</h1>

        <h3>{{ $user->name }}</h3>
        <p>Email: {{ $user->email }}</p>

        <h4>Booked Tickets</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Booked On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->event->name }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ $ticket->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
