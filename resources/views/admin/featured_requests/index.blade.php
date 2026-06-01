@extends('layouts.admin')

@section('content')
    <h2>Featured Ad Requests</h2>

    {{-- Pending Requests --}}
    <h4>Pending Requests</h4>
    
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <tr style="background-color: #DB0405 !important; color: #fff !important;">
                <th>User</th>
                <th>Listing</th>
                <th>For Days</th>
                <th>Rupees</th>
                <th>Receipt</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>
                        <a href="{{ route('listing.show', $request->listing->id) }}">
                            {{ $request->listing->category->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td>
                            {{ $request->days ?? 'N/A' }}
                    </td>
                    <td>
                            {{ $request->rupes ?? 'N/A' }}
                    </td>
                    <td>
                        <a href="{{ Storage::url($request->receipt_image) }}" target="_blank">
                            <img src="{{ Storage::url($request->receipt_image) }}" width="100">
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-warning p-2">Pending</span>
                    </td>
                    <td>
                        <div class="d-flex align-iten-center" style="gap:5px">
                            <form action="{{ route('admin.featured.approve', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.featured.reject', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No pending requests found.</td></tr>
            @endforelse
        </table>
    </div>

    {{-- Approved Listings --}}
    <h4 class="mt-5">Approved Featured Listings</h4>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <tr style="background-color: #DB0405 !important; color: #fff !important;">
                <th>User</th>
                <th>Breed</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
            @forelse($approvedListings as $listing)
                <tr>
                    <td>{{ optional($listing->users)->name ?? 'N/A' }}</td>

                    <td>
                        <a href="{{ route('listing.show', $listing->id) }}">
                            {{ $listing->breed->name ?? 'Untitled' }}
                        </a>
                    </td>
                    <td>{{ $listing->category->name ?? 'N/A' }}</td>
                    <td><span class="badge bg-success text-white p-2">Approved</span></td>
                </tr>
            @empty
                <tr><td colspan="4">No approved listings found.</td></tr>
            @endforelse
        </table>
    </div>
@endsection
