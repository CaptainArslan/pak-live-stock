@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <a href="{{ route('admin.breeds.create') }}" class="btn btn-primary">Add New Breed</a>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header justify-content-between">
                <h2 class="text-black">Breeds Table</h2>
                <div class="card-header-form gap-3">
                   <form method="GET" action="{{ route('admin.breeds.index') }}" class="row gap-3">
                        <!-- Category Filter -->
                        
                        <div class="form-group col-md-4">
                          <select name="category" id="categoryFilter" class="form-control w-100" style="font-size:13px;height:32px !important;padding: 5px 10px!important;" onchange="this.form.submit()">
                             <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                          </select>
                        </div>
        
                        <!-- Date Filter -->
                        <div class="form-group col-md-8 d-flex justify-content-between" style="gap: 10px;">
                            <input type="date" name="date" id="dateFilter" class="form-control datetimepicker"  value="{{ request('date') }}">
                        <!-- Submit Button -->
                            <a><button type="submit" class="btn btn-primary" style="font-size:13px">Apply</button></a>
                            <a href="{{ route('admin.breeds.index') }}"><button class="btn btn-primary bg-white" style="font-size:13px; color:#000">Clear </button></a>
                        </div>
                    </form>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr style="background-color: #DB0405 !important; color: #fff !important;">
                        <th>#</th>
                        <th>Breed Name</th>
                        <th>Categories</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                    
                    @foreach ($breeds as $index => $breed)
                    <tr>
                      <td>{{ $index + $breeds->firstItem() }}</td>
                      <td>{{ $breed->name }}</td>
                      <td class="align-middle">
                        <div>
                            @if($breed->categories->count() > 0)
                                {{ implode(', ', $breed->categories->pluck('name')->toArray()) }}
                            @else
                                <span class="text-muted">No Category</span>
                            @endif
                        </div>
                      </td>
                      <td>
                        {{ $breed->created_at->format('d F Y') }}
                      </td>
                      <td>{{ $breed->updated_at->format('d F Y') }}</td>
                      <td>
                        <div class="badge"><a href="{{ route('admin.breeds.edit', $breed->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form id="delete-breed-{{ $breed->id }}" action="{{ route('admin.breeds.destroy', $breed->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmBreedDelete({{ $breed->id }}, {{ $breed->listings->count() }})">
                                🗑 Delete
                            </button>
                        </form>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </table>
                  <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4 mx-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($breeds->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $breeds->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif
                
                                {{-- Pagination Elements --}}
                                @foreach ($breeds->links()->elements[0] as $page => $url)
                                    @if ($page == $breeds->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                
                                {{-- Next Page Link --}}
                                @if ($breeds->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $breeds->nextPageUrl() }}" rel="next">Next</a>
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
@endsection
