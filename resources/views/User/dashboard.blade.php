@extends("appLayout")
@section("title")
{{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }} Dashboard| {{ config('app.name') }}

@endsection
@section('navbar')
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

@endsection
@section("content")
