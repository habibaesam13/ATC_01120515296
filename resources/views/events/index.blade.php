@extends('appLayout') 

@section('content')
<div class="container">
    <h1>All Events</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Create New Event</a>

    @if($events->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->category->name ?? 'N/A' }}</td>
                        <td>{{ $event->date }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination (if you're using it in the service) --}}
        {{ $events->links() }}

    @else
        <p>No events found.</p>
    @endif
</div>
@endsection
