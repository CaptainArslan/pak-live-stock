@extends('layouts.app')
@section('title', 'Home - Pak Livestock')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!--top banner -->
    <div class="container">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('/assets/images/Slider-1.webp') }}" class="d-block w-100"
                        style="height: auto; object-fit: contain;" alt="Slide 1">
                </div>
                <!--<div class="carousel-item">-->
                <!--  <img src="{{ asset('/assets/images/Slider-2.webp') }}" class="d-block w-100" style="height: 350px; object-fit: cover;" alt="Slide 2">-->
                <!--</div>-->
            </div>
            <!-- Optional controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <!-- Optional indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
        </div>
    </div>

    <!-- Featured Listing Cards Grid -->
    <div class="container my-5 px-lg-5">
        <div class="d-flex justify-content-end mb-2">
            <h1 style="font-weight: 700;">نمایاں فہرست</h1>
        </div>
        <div class="container my-5 px-lg-5">
            <div class="row">

                @foreach ($listings->filter(function ($listing) {
            return ($listing->is_featured || $listing->verified || $listing->warrenty) && !$listing->is_sold;
        }) as $index => $listing)
                    <div class="m-0 p-0 p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-1 listing-item">
                        <div class="card d-flex flex-column pb-1">
                            <div style="position: relative;">
                                @if ($listing->images)
                                    @php $firstImage = json_decode($listing->images)[0] ?? null; @endphp
                                    <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                                        <img src="{{ $firstImage ? Storage::url($firstImage) : asset('/assets/images/listingImage.webp') }}"
                                            class="card-img-top" alt="{{ $listing->category->name }}"
                                            style="height: 150px; width: 100%; object-fit: cover;" />
                                    </a>
                                @endif

                                {{-- Auto-positioned badges --}}
                                <div class="position-absolute bottom-0 start-0 d-flex gap-2 p-2">
                                    @if ($listing->is_featured)
                                        <span
                                            class="badge bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center"
                                            style="width: 25px; height: 25px;">
                                            <i class="bi bi-star-fill text-white"></i>
                                        </span>
                                    @endif
                                    @if ($listing->verified)
                                        <span
                                            class="badge bg-success rounded-circle p-2 d-flex align-items-center justify-content-center"
                                            style="width: 25px; height: 25px;">
                                            <i class="bi bi-patch-check-fill text-white"></i>
                                        </span>
                                    @endif
                                    @if ($listing->warrenty)
                                        <span
                                            class="badge bg-info rounded-circle p-2 d-flex align-items-center justify-content-center"
                                            style="width: 25px; height: 25px;">
                                            <i class="bi bi-shield-fill-check text-white"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-start mt-2">
                                    <p class="m-0 p-0 card-text idnumber">
                                        {{ $listing->id }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button onclick="toggleHeart(this)" class="mb-2 text-dark fs-5 border-0 bg-transparent"
                                        data-user="{{ auth('phoneUser')->check() ? auth('phoneUser')->id() : 0 }}"
                                        data-listing="{{ $listing->id }}" style="cursor: pointer;">
                                        @php
                                            $isLiked = in_array($listing->id, $likedListingIds ?? []);
                                        @endphp

                                        <i class="bi {{ $isLiked ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                    </button>
                                    <a href="{{ route('listing.show', $listing->id) }}"
                                        class="text-decoration-none text-dark">
                                        <h3 class="d-rtl p-0 text-hover">
                                            @php
                                                $catId = $listing->category->id ?? null;
                                                $gender = $listing->gender;
                                                $quantity = $listing->quantity;
                                                $breedName = $listing->breed->name ?? '';
                                            @endphp

                                            @if ($quantity <= 1)
                                                @switch($catId)
                                                    @case(3)
                                                        {{ $gender == 'male' ? 'بکرا' : ($gender == 'female' ? 'بکری' : 'بکرا / بکری') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(4)
                                                        بھیڑ - {{ $breedName }}
                                                    @break

                                                    @case(6)
                                                        {{ $gender == 'male' ? 'کٹا' : ($gender == 'female' ? 'کٹی' : 'کٹا / کٹی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(7)
                                                        {{ $gender == 'male' ? 'بچھڑا' : ($gender == 'female' ? 'بچھڑی' : 'بچھڑا / بچھڑی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(8)
                                                        {{ $gender == 'male' ? 'گھوڑا' : ($gender == 'female' ? 'گھوڑی' : 'گھوڑا / گھوڑی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(9)
                                                        {{ $listing->title ?? '' }}
                                                    @break

                                                    @case(10)
                                                        {{ $gender == 'male' ? 'کتا' : ($gender == 'female' ? 'کتیا' : 'کتا / کتیا') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(11)
                                                        {{ $gender == 'male' ? 'بلّا' : ($gender == 'female' ? 'بلی' : 'بلّا / بلی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(12)
                                                        {{ $gender == 'male' ? 'طوطا' : ($gender == 'female' ? 'طوطی' : 'طوطا / طوطی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(13)
                                                        {{ $gender == 'male' ? 'کبوتر' : ($gender == 'female' ? 'کبوتری' : 'کبوتر / کبوتری') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(14)
                                                        {{ $gender == 'male' ? 'مور' : ($gender == 'female' ? 'مورنی' : 'مور / مورنی') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @default
                                                        {{ $listing->category->name ?? '' }} - {{ $breedName }}
                                                @endswitch
                                            @elseif ($quantity > 1)
                                                @switch($catId)
                                                    @case(3)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'بکرے' : ($gender == 'female' ? 'بکریاں' : 'بکرے / بکریاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(4)
                                                        {{ $quantity }} بھیڑیں - {{ $breedName }}
                                                    @break

                                                    @case(6)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'کٹے' : ($gender == 'female' ? 'کٹیاں' : 'کٹے / کٹیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(7)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'بچھڑے' : ($gender == 'female' ? 'بچھڑیاں' : 'بچھڑے / بچھڑیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(8)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'گھوڑے' : ($gender == 'female' ? 'گھوڑیاں' : 'گھوڑے / گھوڑیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(9)
                                                        {{ $quantity }} {{ $listing->title ?? '' }}
                                                    @break

                                                    @case(10)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'کتے' : ($gender == 'female' ? 'کتیا‌ئیں' : 'کتے / کتیا‌ئیں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(11)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'بلّے' : ($gender == 'female' ? 'بلیاں' : 'بلّے / بلیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(12)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'طوطے' : ($gender == 'female' ? 'طوطیاں' : 'طوطے / طوطیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(13)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'کبوتر' : ($gender == 'female' ? 'کبوتریاں' : 'کبوتر / کبوتریاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @case(14)
                                                        {{ $quantity }}
                                                        {{ $gender == 'male' ? 'مور' : ($gender == 'female' ? 'مورنیاں' : 'مور / مورنیاں') }}
                                                        - {{ $breedName }}
                                                    @break

                                                    @default
                                                        {{ $quantity }} {{ $listing->category->name ?? '' }} -
                                                        {{ $breedName }}
                                                @endswitch
                                            @endif
                                        </h3>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0 p-0 card-text">
                                        <span class="fw-bold h6">
                                            @if ($listing->rate_on_call == 1)
                                                قیمت کال پر
                                            @elseif ($listing->total_price)
                                                {{ number_format($listing->total_price) }}
                                            @elseif ($listing->price_per_animal)
                                                {{ number_format($listing->price_per_animal) }}
                                            @elseif ($listing->price_per_kg)
                                                {{ number_format($listing->price_per_kg) }}
                                            @elseif ($listing->price)
                                                {{ number_format($listing->price) }}
                                            @else
                                                قیمت کال پر
                                            @endif
                                        </span>
                                    </h6>
                                    <i class="bi bi-eye text-hover">
                                        <span>{{ $listing->interaction->view_count ?? 0 }}</span></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="m-0 p-0 card-text">
                                        {{ $listing->created_at->locale('en')->diffForHumans() }}
                                    </p>
                                    <h4 class="m-0 p-0 card-text text-hover">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $listing->city }}
                                    </h4>
                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (count($listings) > 8)
                <div class="text-center my-4">
                    <button id="showMoreBtn" class="btn btn-primary h4 px-4 py-3">
                        مزید دیکھیں
                    </button>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const listings = document.querySelectorAll('.listing-item');

                // Hide all listings after the first 8
                for (let i = 8; i < listings.length; i++) {
                    listings[i] && (listings[i].style.display = 'none');
                }

                let currentVisible = 8;
                const totalListings = listings.length;

                const showMoreBtn = document.getElementById('showMoreBtn');

                if (showMoreBtn) {
                    showMoreBtn.addEventListener('click', function() {
                        const nextVisible = currentVisible + 8;

                        for (let i = currentVisible; i < nextVisible && i < listings.length; i++) {
                            listings[i].style.display = 'block';
                        }

                        currentVisible = nextVisible;

                        if (currentVisible >= totalListings) {
                            this.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    </div>





    @php
        $hasLivestock = $categories->contains(fn($cat) => $cat->main_cat === 'Livestock' && $cat->listings->count());
        $hasPets = $categories->contains(fn($cat) => $cat->main_cat === 'Pets' && $cat->listings->count());
        $hasBirds = $categories->contains(fn($cat) => $cat->main_cat === 'Birds' && $cat->listings->count());
        $hasOther = $categories->contains(fn($cat) => $cat->main_cat === 'Other' && $cat->listings->count());
    @endphp

    @if ($hasLivestock)
        <h1 class="text-center"> مویشی </h1>
        @foreach ($categories as $category)
            @if ($category->main_cat === 'Livestock' && $category->listings->count())
                @include('components.card', [
                    'category' => $category,
                    'index' => $loop->index,
                    'listingRoute' => 'listingFront',
                ])
            @endif
        @endforeach
    @endif

    @if ($hasPets)
        <h1 class="text-center"> پالتو جانور </h1>
        @foreach ($categories as $category)
            @if ($category->main_cat === 'Pets' && $category->listings->count())
                @include('components.card', [
                    'category' => $category,
                    'index' => $loop->index,
                    'listingRoute' => 'petlistingFront',
                ])
            @endif
        @endforeach
    @endif

    @if ($hasBirds)
        <h1 class="text-center"> پرندے </h1>
        @foreach ($categories as $category)
            @if ($category->main_cat === 'Birds' && $category->listings->count())
                @include('components.card', [
                    'category' => $category,
                    'index' => $loop->index,
                    'listingRoute' => 'birdListingFront',
                ])
            @endif
        @endforeach
    @endif

    @if ($hasOther)
        <h1 class="text-center"> ساز و سامان </h1>
        @foreach ($categories as $category)
            @if ($category->main_cat === 'Other' && $category->listings->count())
                @include('components.card', [
                    'category' => $category,
                    'index' => $loop->index,
                    'listingRoute' => 'otherListingFront',
                ])
            @endif
        @endforeach
    @endif



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function handleListingClick(categoryId, direction) {
            const container = document.getElementById('listingScrollWrapper' + categoryId);
            const scrollAmount = container.querySelector('.item2').offsetWidth + 150;
            container.scrollBy({
                left: direction === 'next' ? scrollAmount : -scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
    <script>
        var featuredSwiper = new Swiper(".myFeaturedSwiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".featured-button-next",
                prevEl: ".featured-button-prev",
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4.2,
                },
            },
        });
        // <!-- All Categories Tabs -->
        var categorySwiper = new Swiper(".categorySwiper", {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: ".category-button-next",
                prevEl: ".category-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.5,
                },
                768: {
                    slidesPerView: 3.5,
                },
                992: {
                    slidesPerView: 4.5,
                }
            },
        });
        //   <!-- // Categories Slider -->
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.myCowSwiper').forEach(function(el) {
                const indexClass = Array.from(el.classList).find(cls => cls.startsWith('myCowSwiper-'));

                if (!indexClass) return;

                const index = indexClass.split('-').pop();

                new Swiper(el, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    loop: true,
                    navigation: {
                        nextEl: `.swiper-button-next-${index}`,
                        prevEl: `.swiper-button-prev-${index}`,
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2
                        },
                        768: {
                            slidesPerView: 3
                        },
                        992: {
                            slidesPerView: 4
                        },
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleHeart(button) {
            const userId = button.getAttribute('data-user');
            const listingId = button.getAttribute('data-listing');
            const icon = button.querySelector('i');

            if (!userId || userId == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'Please log in to like a listing!',
                });
                return;
            }

            fetch('/listing/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        listing_id: listingId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Liked listing IDs:", data.liked_listing_ids);

                    if (data.status === 'liked') {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill', 'text-danger');

                        Swal.fire({
                            icon: 'success',
                            title: 'Liked!',
                            text: 'You liked this listing.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    } else {
                        icon.classList.remove('bi-heart-fill', 'text-danger');
                        icon.classList.add('bi-heart');

                        Swal.fire({
                            icon: 'info',
                            title: 'Unliked',
                            text: 'You removed this listing from liked.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                })

                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Failed to like/unlike listing.',
                    });
                });
        }
    </script>


@endsection
