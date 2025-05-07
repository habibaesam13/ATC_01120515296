@extends('appLayout')

@section('content')
    <div class="container">
        <h1>Create New Category</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Create Category</button>
        </form>
    </div>
@endsection
