@extends('layouts.admin')

<link rel="stylesheet" href="{{ asset('bundles/summernote/summernote-bs4.css') }}">

@section('content')
<div class="container mt-4">
    <div>
        <h2 class="mb-4">Add New Information</h2>
    </div>
    <div >
        <form action="{{ route('admin.informations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            {{-- Video Link --}}
            <div class="mb-3">
                <label for="video_link" class="form-label">Video Link (YouTube, Vimeo, etc.)</label>
                <input type="url" class="form-control" id="video_link" name="video_link">
            </div>

            {{-- Video Upload --}}
            <!--<div class="mb-3">-->
            <!--    <label for="video" class="form-label">Upload Video</label>-->
            <!--    <input type="file" class="form-control" id="video" name="video" accept="video/*">-->
            <!--</div>-->

            {{-- Description (Rich Text Editor) --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="summernote" name="description" rows="5"></textarea>
            </div>

            {{-- Submit Button --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('bundles/summernote/summernote-bs4.js') }}"></script>


@endsection
