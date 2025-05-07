@extends('appLayout') 
@section('content')
    <div class="container">
        <h1>Create Event</h1>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Event Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" required min="0" step="0.01">
            </div>
            <div class="form-group">
        <label for="category_name">Category</label>
        <select name="category_name" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg">
            </div>
            <div class="form-group">
                <label for="number_of_tickets">Number of Tickets</label>
                <input type="number" name="number_of_tickets" class="form-control" required min="1">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="venue">Venue</label>
                <input type="text" name="venue" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Create Event</button>
        </form>
    </div>
@endsection
