@extends('layouts.sidebar')
@section('title', 'User Profile')
@section('sidebarContent')
<div class="container my-5">
    <h2 class="text-center fw-bold mb-4">اطلاعات</h2>

    {{-- Pending Requests --}}
    <div class="mb-5">
        <h4 class="text-dark mb-3 text-end" >زیر التواء درخواستیں</h4>

        @if($pendingRequests->count() > 0)
            <div class="table-responsive shadow rounded">
                <table class="table table-hover align-middle table-bordered mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>تصویر</th>
                            <th>قسم</th>
                            <th>نسل</th>
                            <th>شہر</th>
                            <th>قیمت</th>
                            <th>درخواست</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                        <tr class="text-center">
                            <td>
                                @if($request->listing->images)
                                    @php $images = json_decode($request->listing->images); @endphp
                                    <img src="{{ Storage::url($images[0]) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $request->listing->category->name ?? 'N/A' }}</td>
                            <td>{{ $request->listing->breed->name ?? 'N/A' }}</td>
                            <td>{{ $request->listing->city ?? 'N/A' }}</td>
                            <td>Rs {{ number_format($request->listing->price ?? 0) }}</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center mt-3">کوئی زیر التواء درخواست موجود نہیں۔</div>
        @endif
    </div>

    {{-- Approved Requests --}}
    <div class="mb-5">
        <h4 class="text-dark mb-3 text-end">منظور شدہ درخواستیں</h4>

        @if($approvedRequests->count() > 0)
            <div class="table-responsive shadow rounded">
                <table class="table table-hover align-middle table-bordered mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>تصویر</th>
                            <th>قسم</th>
                            <th>نسل</th>
                            <th>شہر</th>
                            <th>قیمت</th>
                            <th>درخواست</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedRequests as $request)
                        <tr class="text-center">
                            <td>
                                @if($request->listing->images)
                                    @php $images = json_decode($request->listing->images); @endphp
                                    <img src="{{ Storage::url($images[0]) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $request->listing->category->name ?? 'N/A' }}</td>
                            <td>{{ $request->listing->breed->name ?? 'N/A' }}</td>
                            <td>{{ $request->listing->city ?? 'N/A' }}</td>
                            <td>Rs {{ number_format($request->listing->price ?? 0) }}</td>
                            <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center mt-3">کوئی منظور شدہ درخواست موجود نہیں۔</div>
        @endif
    </div>
</div>

@endsection
