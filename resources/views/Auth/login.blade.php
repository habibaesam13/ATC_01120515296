@extends("appLayout")
@section("title")
Login | {{ config('app.name') }}
@endsection

@section("content")
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px;">
        <h4 class="mb-4 text-center">Login</h4>
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="exampleInputEmail1"
                    required
                >
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-control @error('pass') is-invalid @enderror" 
                    id="password" 
                    name="password"
                    required
                >
                @error('pass')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
        </form>

        <div class="text-center mt-2">
            <small>
                Don't have an account? 
                <a href="{{ route('register') }}">Register here</a>
            </small>
        </div>
    </div>
</div>
@endsection
