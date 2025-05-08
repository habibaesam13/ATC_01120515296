@extends('appLayout')
@section('title')
Edit Category | {{ config('app.name') }}
@endsection
@section('content')
    <div class="container">
        <h1>Edit Category</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display session error (like duplicate name) --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $category->name) }}"
                    required
                >
            </div>

            <button type="submit" class="btn btn-warning mt-3">Update Category</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3 ms-2">Back</a>
        </form>
    </div>
@endsection
