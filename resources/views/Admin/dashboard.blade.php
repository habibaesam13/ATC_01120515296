@extends('appLayout')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Categories Table -->
    <h3>Categories</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create New Category</a>
    <table class="table table-bordered table-striped mb-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                </tr>
            @empty
                <tr><td colspan="2">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
