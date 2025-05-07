@extends('appLayout')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning mt-3">Update Category</button>
        </form>
    </div>
@endsection
