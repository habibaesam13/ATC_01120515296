@extends('appLayout')

@section('content')
    <div class="container">
        <h1>Edit Event</h1>
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Event Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $event->price) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="category_name">Category</label>
                <select name="category_name" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}" {{ $event->category_name == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" name="image" class="form-control">
                @if ($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" width="100">
                @endif
            </div>

            <div class="form-group">
                <label for="number_of_tickets">Number of Tickets</label>
                <input type="number" name="number_of_tickets" class="form-control" value="{{ old('number_of_tickets', $event->number_of_tickets) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', $event->date) }}" required>
            </div>

            <div class="form-group">
                <label for="venue">Venue</label>
                <input type="text" name="venue" class="form-control" value="{{ old('venue', $event->venue) }}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Event</button>
        </form>
    </div>
@endsection
