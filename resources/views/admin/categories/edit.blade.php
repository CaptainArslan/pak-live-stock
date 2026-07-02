@extends('layouts.admin')

@section('content')
    <h2>Edit Category</h2>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Main Category Type</label>
        <select name="main_cat" class="form-control" required>
            <option value="">Select Main Category</option>
            <option value="Livestock" {{ $category->main_cat === 'Livestock' ? 'selected' : '' }}>Livestock</option>
            <option value="Birds" {{ $category->main_cat === 'Birds' ? 'selected' : '' }}>Birds</option>
            <option value="Pets" {{ $category->main_cat === 'Pets' ? 'selected' : '' }}>Pets</option>
            <option value="Other" {{ $category->main_cat === 'Other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Category Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    @if($category->image)
        <div>
            <img src="{{ asset('storage/app/public/' . $category->image) }}" width="100">
        </div>
    @endif

    <button type="submit" class="btn btn-primary">Update Category</button>
</form>

@endsection
