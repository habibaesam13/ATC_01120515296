@extends("appLayout")

@section("title")
    Congratulations | {{ config('app.name') }}
@endsection

@section("content")
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Congratulations!</h5>
                    <p class="card-text">You have successfully booked your ticket for the event.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary">Go Back to Events</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
