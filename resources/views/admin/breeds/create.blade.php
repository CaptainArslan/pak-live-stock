@extends('layouts.admin')

@section('content')
    <h2>Create Breed</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('admin.breeds.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Breed Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Categories</label><br>
            @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="categories[]" 
                           value="{{ $category->id }}" 
                           id="category_{{ $category->id }}">
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Create Breed</button>
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('input[name="name"]').on('input', function () {
            let breedName = $(this).val().trim();
            console.log(breedName);

            if (breedName.length > 1) {
                $.ajax({
                    url: '{{ route("admin.breeds.check") }}',
                    type: 'GET',
                    data: { name: breedName },
                    success: function (response) {
                        // Uncheck all checkboxes first
                        $('input[name="categories[]"]').prop('checked', false);

                        // If breed exists, check associated categories
                        if (response.exists) {
                            response.category_ids.forEach(function (id) {
                                $('#category_' + id).prop('checked', true);
                            });
                        }
                    },
                    error: function (xhr) {
                        console.log("AJAX error:", xhr.responseText);
                    }
                });
            }
        });
    });
</script>


@endsection
