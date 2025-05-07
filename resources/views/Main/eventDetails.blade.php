@extends("appLayout")

@section("title")
    Event Details | {{ config('app.name') }}
@endsection

@section("content")
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                @if($event->image)
                    <img src="{{ asset('storage/eventImages/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text"><strong>Description:</strong> {{ $event->description }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $event->category->name }}</p>
                    <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                    <p class="card-text"><strong>Venue:</strong> {{ $event->venue }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ $event->price }}</p>

                    @auth
                        @if(auth()->user()->events->contains($event->id))
                            <span class="badge bg-success">Booked</span>
                        @else
                            @if($event->tickets->where('status', 'available')->count() > 0)
                                <form action="{{ route('tickets.book', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </form>
                            @else
                                <span class="badge bg-danger">No Available Tickets</span>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login to Book</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
