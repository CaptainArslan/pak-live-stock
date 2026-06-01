@extends('layouts.admin')

@section('content')
    
    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header justify-content-between">
                <h2 class="text-black">Categories Table</h2>
                <div class="card-header-form gap-3">
                   <form method="GET" action="{{ route('admin.categories.index') }}" id="filterForm" class="row gap-3">
                       <!-- Date Filter -->
                        <div class="form-group col-md-8 d-flex justify-content-between" style="gap: 10px;">
                            <input type="date" name="date" id="dateFilter" class="form-control datetimepicker"  value="{{ request('date') }}">
                        <!-- Submit Button -->
                            <a><button type="submit" class="btn btn-primary" style="font-size:13px">Apply</button></a>
                            <a href="{{ route('admin.categories.index') }}"><button class="btn btn-primary bg-white text-black" style="font-size:13px; color:#000;">Clear </button></a>
                        </div>
                    </form>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr style="background-color: #DB0405 !important; color: #fff !important;">
                        <th >#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Main Category</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                    
                    @foreach($categories as $index => $category)
                    <tr>
                        <td>{{ $index + $categories->firstItem() }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" width="50" class="img-thumbnail">
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="fw-semibold">{{ $category->main_cat }}</td>
                        <td>{{ $category->created_at->format('d F Y') }}</td>
                        <td>{{ $category->updated_at->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <!--<form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">-->
                            <!--    @csrf-->
                            <!--    @method('DELETE')-->
                            <!--    <button type="button" class="btn btn-danger btn-sm"-->
                            <!--        onclick="confirmDelete({{ $category->id }}, {{ $category->listings->count() }})">-->
                            <!--         Delete-->
                            <!--    </button>-->
                            <!--</form>-->
                        </td>
                        </tr>
                    @endforeach
                  </table>
                  <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($categories->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link"><</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev"><</a>
                                    </li>
                                @endif
                
                                {{-- Pagination Elements --}}
                                @foreach ($categories->links()->elements[0] as $page => $url)
                                    @if ($page == $categories->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                
                                {{-- Next Page Link --}}
                                @if ($categories->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">></a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">></span></li>
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
            function confirmDelete(categoryId, listingCount) {
                let message = listingCount > 0
                    ? `⚠️ This category has ${listingCount} associated listings. Deleting it will remove all related listings. Do you want to proceed?`
                    : "Are you sure you want to delete this category?";
    
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
                        document.getElementById(`delete-form-${categoryId}`).submit();
                    }
                });
            }
        </script>
@endsection
