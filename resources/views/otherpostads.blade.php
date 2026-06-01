@extends('layouts.app')
@section('title', 'Pet Post Ads - Pak Livestock')

@section('content')
    <div class="container mt-5">
        <h2 style="direction:rtl"> اپنی پوسٹ شامل کریں۔</h2><br><br>
        @include('components.other-listing-form', [
            'route' => route('postlisting'),
            'provinces' => $provinces
        ])

    </div>
@endsection
