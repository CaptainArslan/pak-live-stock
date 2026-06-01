@extends('layouts.admin')

@section('content')
    <h2>Edit Breed</h2>

    <form action="{{ route('admin.breeds.update', $breed->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Breed Name</label>
            <input type="text" name="name" class="form-control" value="{{ $breed->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Categories</label><br>
            @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="categories[]" 
                           value="{{ $category->id }}" 
                           id="category_{{ $category->id }}" {{ $breed->categories->contains($category->id) ? 'checked' : '' }} >
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update Breed</button>
    </form>
@endsection
