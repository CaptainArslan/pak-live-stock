@extends('layouts.app')
@section('title', 'Pre Form - Pak Livestock')
<style>
    .card-hover:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease;
    }
    .card-title{font-size:2em !important; }
    .card-img-top{height: 200px; object-fit:cover;}
    .card-title{line-height: auto!important; height: auto !important;}
</style>
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">

        <!-- Card 1 -->
        <div class="col">
            <a href="/postads" style="text-decoration:none;">
                <div class="card card-hover h-100 text-center">
                    <img src="{{ asset('/assets/images/livestock.png') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h2 class="card-title"> مویشی </h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="/petpostads" style="text-decoration:none;">
                <div class="card card-hover h-100 text-center">
                    <img src="{{ asset('/assets/images/pets.png') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h2 class="card-title"> پالتو جانور </h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="/birdpostads" style="text-decoration:none;">
                <div class="card card-hover h-100 text-center">
                    <img src="{{ asset('/assets/images/birds.png') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h2 class="card-title"> پرندے </h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="/otherpostads" style="text-decoration:none;">
                <div class="card card-hover h-100 text-center">
                    <img src="{{ asset('/assets/images/others.png') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h2 class="card-title"> ساز و سامان </h2>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
