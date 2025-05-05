@extends("appLayout")
@section("title")
{{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }} Dashboard| {{ config('app.name') }}

@endsection

@section("content")
