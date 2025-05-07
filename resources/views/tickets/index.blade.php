@extends('appLayout')
@section('content')
<div class="container">
    <h1>Manage Tickets</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Event</th>
                <th>Status</th>
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