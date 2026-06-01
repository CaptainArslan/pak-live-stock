@extends('layouts.admin')


@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <a href="{{ route('admin.informations.create') }}" class="btn btn-primary">Add New Info</a>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header justify-content-between">
                <h2 class="text-black">Info Table</h2>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                   <tr style="background-color: #DB0405 !important; color: #fff !important;">
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                    
                    @foreach ($informations as $index => $info)
                        <tr>
                            <td>{{ $index + $informations->firstItem() }}</td>
                            <td>{{ $info->title }}</td>
                            <td>
                                @if ($info->image)
                                    <img src="{{ Storage::url($info->image) }}" alt="Image" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                @if ($info->video_link)
                                    <a href="{{ $info->video_link }}" target="_blank">Watch Video</a>
                                @elseif ($info->video)
                                    <video width="80" height="50" controls>
                                        <source src="{{ Storage::url($info->video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    No Video
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.informations.edit', $info->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.informations.destroy', $info->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
                                @if ($informations->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $informations->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif
                
                                {{-- Pagination Elements --}}
                                @foreach ($informations->links()->elements[0] as $page => $url)
                                    @if ($page == $informations->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                
                                {{-- Next Page Link --}}
                                @if ($informations->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $informations->nextPageUrl() }}" rel="next">Next</a>
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

