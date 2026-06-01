@extends('layouts.admin')

@section('content')
    <h2>Add New Category</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Main Category Type</label>
            <select name="main_cat" class="form-control" required>
                <option value="">Select Main Category</option>
                <option value="Livestock">Livestock</option>
                <option value="Birds">Birds</option>
                <option value="Pets">Pets</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Category Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
@endsection
