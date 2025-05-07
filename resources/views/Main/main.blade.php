@extends("appLayout")

@section("title")
Home Page | {{ config('app.name') }}
@endsection

@section("content")
<div class="container mt-4">
    <div class="row">
        @foreach ($events as $event)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($event->image)
                <img src="{{ asset('public/eventImages/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ $event->price }}</p>
                    <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                    <p class="card-text"><strong>Venue:</strong> {{ $event->venue }}</p>
                    @auth
                    @if(auth()->user()->events->contains($event->id))
                    <span class="badge bg-success mt-auto">Booked</span>
                    <div class="d-flex justify-content-center mt-2">
                        <form action="{{ route('tickets.unbook', ['eventId' => $event->id, 'ticketId' => auth()->user()->events->find($event->id)->pivot->ticket_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Unbook</button>
                        </form>

                    </div>
                    @else
                    <form action="{{ route('tickets.book', ['eventId' => $event->id, 'ticketId' => $event->tickets->first()->id ?? '']) }}" method="POST" class="mt-auto">
                        @if($event->tickets->isNotEmpty())
                        <button type="submit" class="btn btn-primary w-100">Book Now</button>
                        @else
                        <p>No tickets available</p>
                        @endif
                    </form>

                    @endif
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto w-100">Login to Book</a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection