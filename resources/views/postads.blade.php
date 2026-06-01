@extends('layouts.app')
@section('title', 'Post Ads - Pak Livestock')

@section('content')
    <div class="container mt-5">
        <h2 style="direction:rtl"> اپنی پوسٹ شامل کریں۔</h2><br><br>
        @include('components.listing-form', [
            'route' => route('postlisting'),
            'provinces' => $provinces
        ])

    </div>
@endsection
