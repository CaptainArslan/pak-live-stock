@extends('layouts.admin')

<link rel="stylesheet" href="{{ asset('bundles/summernote/summernote-bs4.css') }}">

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Information "{{ old('title', $information->title) }}" </h2>

    <form action="{{ route('admin.informations.update', $information->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $information->title) }}" required>
        </div>

        {{-- Description (Rich Text) --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="summernote" name="description">{{ old('description', $information->description) }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="image">
            @if ($information->image)
                <div class="mt-2">
                    <img src="{{ Storage::url($information->image) }}" class="img-thumbnail" width="200">
                </div>
            @endif
        </div>

        {{-- Video Link --}}
        <div class="mb-3">
            <label class="form-label">Video Link</label>
            <input type="url" class="form-control" name="video_link" value="{{ old('video_link', $information->video_link) }}">
        </div>

        {{-- Video Upload --}}
        <!--<div class="mb-3">-->
        <!--    <label class="form-label">Upload Video</label>-->
        <!--    <input type="file" class="form-control" name="video_upload">-->
        <!--    @if ($information->video_upload)-->
        <!--        <div class="mt-2">-->
        <!--            <video width="200" controls>-->
        <!--                <source src="{{ Storage::url($information->video_upload) }}" type="video/mp4">-->
        <!--            </video>-->
        <!--        </div>-->
        <!--    @endif-->
        <!--</div>-->

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Update information</button>
    </form>
</div>

<script src="{{ asset('bundles/summernote/summernote-bs4.js') }}"></script>

@endsection
