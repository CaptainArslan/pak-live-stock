@extends('layouts.admin')

@section('content')
    <h2 style="direction:rtl"> اپنی پوسٹ شامل کریں۔</h2><br><br>
    @include('components.listing-form', [
        'route' => route('admin.listings.store'),
        'provinces' => $provinces
    ])

@endsection
