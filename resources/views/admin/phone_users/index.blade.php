@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <a href="{{ route('phone-users.create') }}" class="btn btn-primary">Add New User</a>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header justify-content-between">
                <h2 class="text-black">Users Table</h2>
                <div class="card-header-form gap-3">
                   <form method="GET" action="{{ route('phone-users.index') }}" class="row gap-3">
                        <!-- Category Filter -->
                        
                        <div class="form-group col-md-4">
                           <input type="text" name="search" id="search" class="form-control"
                           placeholder="Enter name or phone..." value="{{ request('search') }}">
                        </div>
        
                        <!-- Date Filter -->
                        <div class="form-group col-md-8 d-flex justify-content-between" style="gap: 10px;">
                            <input type="date" name="date" id="dateFilter" class="form-control datetimepicker"  value="{{ request('date') }}">
                        <!-- Submit Button -->
                            <a><button type="submit" class="btn btn-primary" style="font-size:13px">Apply</button></a>
                            <a href="{{ route('phone-users.index') }}"><button class="btn btn-primary bg-white text-black" style="font-size:13px; color:#000;">Clear </button></a>
                        </div>
                    </form>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <tr style="background-color: #DB0405 !important; color: #fff !important;">
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                    
                   @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + $users->firstItem() }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->created_at->format('d F Y') }}</td>
                            <td>{{ $user->updated_at->format('d F Y') }}</td>
                            <td>
                                <a href="{{ route('phone-users.edit', $user->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <form id="delete-user-{{ $user->id }}" action="{{ route('phone-users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmUserDelete({{ $user->id }})">
                                        🗑 Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  </table>
                  <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif
                    
                                {{-- Pagination Elements --}}
                                @foreach ($users->links()->elements[0] as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                    
                                {{-- Next Page Link --}}
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
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
    </div>


<!-- SweetAlert Delete Confirmation -->
<script>
    function confirmUserDelete(userId) {
        Swal.fire({
            title: "Confirm Deletion",
            text: "Are you sure you want to delete this user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-user-${userId}`).submit();
            }
        });
    }
</script>

@endsection
