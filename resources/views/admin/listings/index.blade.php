@extends('layouts.admin')

@section('content')
    
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="w-100 d-flex justify-content-end">
                <button id="delete-old-listings" class="btn btn-danger justify-content-end mb-3">
                    Delete Listings Older Than 30 Days
                </button>
              </div>
            <div class="card">
              <div class="card-header justify-content-between">
                <h2 class="text-black col-md-4">Listing Table</h2>
                <div class="card-header-form col-md-8 gap-3">
                   <form method="GET" id="filterForm" action="{{ route('admin.listings.index') }}" class="row justify-content-end gap-3">
                        <!-- Category Filter -->
                        
                        <div class="form-group col-md-3 ">
                          <select name="category" id="categorySelect" class="form-control w-100" style="font-size:13px;height:32px !important;padding: 5px 10px!important;">
                             <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <select name="breed" id="breedSelect" class="form-control w-100" style="font-size:13px;height:32px !important;padding: 5px 10px!important;" {{ request('category') ? '' : 'disabled' }}>
                               <option value="">All Breeds</option>
                                
                          </select>
                        </div>
                       <div class="form-group col-md-3">
                            <select name="search" id="search" class="form-control">
                                <option value="">شہر منتخب کریں</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('search') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <input type="number" name="min_price" id="minPrice" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                        </div>
            
                        <!-- Price Range -->
                        <!-- Date Filter -->
                        <div class="form-group col-md-3" style="gap: 10px;">
                            <input type="date" name="date" id="dateFilter" class="form-control datetimepicker"  value="{{ request('date') }}">
                        </div>
            
                        <!-- Submit & Reset Buttons -->
                        <div class="">
                            <a><button type="submit" class="btn btn-primary" style="font-size:13px">Apply</button></a>
                            <a href="{{ route('admin.listings.index') }}"><button class="btn btn-primary bg-white text-black" style="font-size:13px; color:#000;">Clear </button></a>
                        </div>
                    </form>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr style="background-color: #DB0405 !important; color: #fff !important;">
                        <th>#</th>
                        <th>id</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Breed</th>
                        <th>Price</th>
                        <th>City</th>
                        <th>Featured</th>
                        <th>view</th>
                        <th>share</th>
                        <th>contacts</th>
                        <th>Created at</th>
                        <th>Update at</th>
                        <th>Actions</th>
                    </tr>
                    
                     @foreach ($listings as $index => $listing)
                        <tr>
                            <td>{{ $index + $listings->firstItem() }}</td>
                            <td>{{ $listing->id }}</td>
                            <td>
                                @if($listing->images)
                                @php $firstImage = json_decode($listing->images)[0] ?? null; @endphp
                                    <img src="{{ $firstImage ? Storage::url($firstImage) : asset('assets/images/listingImage.webp') }}" class="img-thumbnail" style="width: 50px;">
                                @endif
                            </td>
                            <td>{{ $listing->category->name }}</td>
                            <td>{{ $listing->breed->name ?? 'N/A' }}</td>
                            <td><strong>Rs {{ number_format($listing->price ?? $listing->total_price) }}</strong></td>
                            <td>{{ $listing->city }}</td>
                            <td>
                                <span class="badge {{ $listing->is_featured ? 'bg-success' : 'bg-secondary' }} text-white">
                                    {{ $listing->is_featured ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>{{ $listing->interaction->view_count ?? 0 }}</td>
                            <td>{{ $listing->interaction->share_clicks ?? 0 }}</td>
                            <td>{{ $listing->interaction->contact_clicks ?? 0 }}</td>
                            <td>{{ $listing->created_at->format('d F Y') }}</td>
                            <td>{{ $listing->updated_at->format('d F Y') }}</td>
                            <td>
                                <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            
                                <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  </table>
                  <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($listings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $listings->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif
                    
                                {{-- Pagination Elements --}}
                                @foreach ($listings->links()->elements[0] as $page => $url)
                                    @if ($page == $listings->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                    
                                {{-- Next Page Link --}}
                                @if ($listings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $listings->nextPageUrl() }}" rel="next">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <!-- SweetAlert Confirmation for Delete -->
        <script>
            function confirmBreedDelete(breedId, listingCount) {
                let message = listingCount > 0
                    ? `⚠️ Warning: This breed has ${listingCount} associated listings.\n\nDeleting it will remove all related listings. Do you want to proceed?`
                    : "Are you sure you want to delete this breed?";
    
                Swal.fire({
                    title: "Confirm Deletion",
                    text: message,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-breed-${breedId}`).submit();
                    }
                });
            }
        </script>
    </div>



<script>
    
    document.addEventListener("DOMContentLoaded", function () {
    let filterForm = document.getElementById("filterForm");
    let categorySelect = document.getElementById("categorySelect");
    let breedSelect = document.getElementById("breedSelect");

    // If a category is preselected on page load, load breeds for it
    if (categorySelect.value) {
        fetchBreeds(categorySelect.value, true);
    }

    categorySelect.addEventListener("change", function () {
        let categoryId = this.value;
        fetchBreeds(categoryId, false);
    });

    function fetchBreeds(categoryId, selectExistingBreed) {
        breedSelect.innerHTML = '<option value="">All Breeds</option>';
        breedSelect.disabled = true;

        if (!categoryId) return;

        fetch(`/breeds/by-category/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length) {
                    data.forEach(breed => {
                        let option = document.createElement('option');
                        option.value = breed.id;
                        option.textContent = breed.name;
                        breedSelect.appendChild(option);
                    });
                    breedSelect.disabled = false;

                    // If the user had a breed selected before reload, keep it selected
                    if (selectExistingBreed) {
                        let selectedBreedId = "{{ request('breed') }}";
                        if (selectedBreedId) {
                            breedSelect.value = selectedBreedId;
                        }
                    }
                } else {
                    breedSelect.innerHTML = '<option value="">No breeds available</option>';
                    breedSelect.disabled = true;
                }
            })
            .catch(err => {
                console.error('Error fetching breeds:', err);
                breedSelect.innerHTML = '<option value="">Error loading breeds</option>';
            });
    }
});


   
    // sweet aleart
    
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest("form").submit(); // Proceed with deletion
                    }
                });
            });
        });
    });

    
    document.getElementById('delete-old-listings').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete all listings older than 30 days!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send POST request to Laravel route
                fetch("{{ route('listings.delete.old') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload(); // reload the page to see the updated listings
                    });
                })
                .catch(error => {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                    console.error('Error:', error);
                });
            }
        });
    });


</script>

@endsection
