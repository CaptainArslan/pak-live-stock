@extends('layouts.app')
@section('title', 'Pets - Pak Livestock')
@section('content')
<!-- Product Cards Grid -->
<div class="container px-lg-5 mt-md-5">
    <h1 class="d-flex justify-content-end" style="font-weight: 700;">سلیکٹ کیٹگری</h1>
    <div class="d-flex justify-content-center align-items-center">
    <div class="pe-1 category-button-prev d-flex justify-content-center align-items-center text-center">
      <i class="bi bi-arrow-left-square-fill fs-3"></i>
    </div>
    <div class="swiper categorySwiper">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                @if (!$mainCat || $category->main_cat == $mainCat)
                    <a href="/petlistingFront?category={{ $category->id }}" class="d-flex justify-content-between px-lg-4 swiper-slide card-slider text-dark card" style="text-decoration: none !important;">
                        @if($category->image)
                            <img src="{{ asset('storage/app/public/' . $category->image) }}" style="width: 50px; height: 50px;" alt="{{ $category->name }}">
                        @else
                            <img src="{{ asset('/assets/images/listingImage.webp') }}" style="width: 50px; height: 50px;" alt="No Image">
                        @endif
                        <div class="ps-3">
                            <span class="m-0 p-0 pb-1 text-dark text-hover" style="font-weight: 700;">{{ $category->name }}</span>
                        </div>
                    </a>
                @endif
            @endforeach

        </div>
    </div>

    <div class="ps-1 category-button-next d-flex justify-content-center align-items-center text-center">
      <i class="bi bi-arrow-right-square-fill fs-3"></i>
    </div>
  </div>
  </div>


    <div class="container my-5 px-lg-5">
        <form method="GET" action="{{ url('/petlistingFront') }}" class="row g-3 mb-4 justify-content-center">

            <input type="hidden" name="category" value="{{ request('category') }}">
            <div class="col-md-2">
                <select name="province" class="form-select">
                    <option value="">صوبہ منتخب کریں</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="city" class="form-select">
                    <option value="">شہر منتخب کریں</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="breed" class="form-select">
                    <option value="">نسل منتخب کریں</option>
                    @foreach($breeds as $breed)
                        <option value="{{ $breed->id }}" {{ request('breed') == $breed->id ? 'selected' : '' }}>{{ $breed->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="sort_price" class="form-select">
                    <option value="">قیمت کے لحاظ سے</option>
                    <option value="high" {{ request('sort_price') == 'high' ? 'selected' : '' }}>زیادہ قیمت</option>
                    <option value="low" {{ request('sort_price') == 'low' ? 'selected' : '' }}>کم قیمت</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">فلٹر کریں</button>
            </div>
        </form>

        <div class="row">
            @php
              $sortedListings = $listings->sortByDesc(function ($listing) {
                  return [$listing->verified, $listing->warrenty, $listing->is_featured, $listing->created_at];
              });
            @endphp
            @foreach ($sortedListings as $index => $listing)
            <div class="m-0 p-0 p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-1 listing-item">
                <div class="card d-flex flex-column pb-1">
                   <div style="position: relative;">
                        @if($listing->images)
                            @php $firstImage = json_decode($listing->images)[0] ?? null; @endphp
                            <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                                <img
                                    src="{{ $firstImage ? asset('storage/app/public/' . $firstImage) : asset('/assets/images/listingImage.webp') }}"
                                    class="card-img-top"
                                    alt="{{ $listing->category->name }}"
                                    style="height: 150px; width: 100%; object-fit: cover;" />
                            </a>
                        @endif

                        {{-- Auto-positioned badges --}}
                        <div class="position-absolute bottom-0 start-0 d-flex gap-2 p-2">
                            @if($listing->is_featured)
                                <span class="badge bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px;">
                                    <i class="bi bi-star-fill text-white"></i>
                                </span>
                            @endif
                            @if($listing->verified)
                                <span class="badge bg-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px;">
                                    <i class="bi bi-patch-check-fill text-white"></i>
                                </span>
                            @endif
                            @if($listing->warrenty)
                                <span class="badge bg-info rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px;">
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
                                <button
                                    onclick="toggleHeart(this)"
                                    class="mb-2 text-dark fs-5 border-0 bg-transparent"
                                    data-user="{{ auth('phoneUser')->check() ? auth('phoneUser')->id() : 0 }}"
                                    data-listing="{{ $listing->id }}"
                                    style="cursor: pointer;">
                                    @php
                                        $isLiked = in_array($listing->id, $likedListingIds ?? []);
                                    @endphp

                                    <i class="bi {{ $isLiked ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                </button>

                                <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none text-dark">
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
                                                        {{ $gender == 'male' ? 'بکرا' : ($gender == 'female' ? 'بکری' : 'بکرا / بکری') }} - {{ $breedName }}
                                                        @break
                                                    @case(4)
                                                        بھیڑ - {{ $breedName }}
                                                        @break
                                                    @case(6)
                                                        {{ $gender == 'male' ? 'کٹا' : ($gender == 'female' ? 'کٹی' : 'کٹا / کٹی') }} - {{ $breedName }}
                                                        @break
                                                    @case(7)
                                                        {{ $gender == 'male' ? 'بچھڑا' : ($gender == 'female' ? 'بچھڑی' : 'بچھڑا / بچھڑی') }} - {{ $breedName }}
                                                        @break
                                                    @case(8)
                                                        {{ $gender == 'male' ? 'گھوڑا' : ($gender == 'female' ? 'گھوڑی' : 'گھوڑا / گھوڑی') }} - {{ $breedName }}
                                                        @break
                                                    @case(9)
                                                        {{ $listing->title ?? '' }}
                                                        @break
                                                    @case(10)
                                                        {{ $gender == 'male' ? 'کتا' : ($gender == 'female' ? 'کتیا' : 'کتا / کتیا') }} - {{ $breedName }}
                                                        @break
                                                    @case(11)
                                                        {{ $gender == 'male' ? 'بلّا' : ($gender == 'female' ? 'بلی' : 'بلّا / بلی') }} - {{ $breedName }}
                                                        @break
                                                    @case(12)
                                                        {{ $gender == 'male' ? 'طوطا' : ($gender == 'female' ? 'طوطی' : 'طوطا / طوطی') }} - {{ $breedName }}
                                                        @break
                                                    @case(13)
                                                        {{ $gender == 'male' ? 'کبوتر' : ($gender == 'female' ? 'کبوتری' : 'کبوتر / کبوتری') }} - {{ $breedName }}
                                                        @break
                                                    @case(14)
                                                        {{ $gender == 'male' ? 'مور' : ($gender == 'female' ? 'مورنی' : 'مور / مورنی') }} - {{ $breedName }}
                                                        @break
                                                    @default
                                                        {{ $listing->category->name ?? '' }} - {{ $breedName }}
                                                @endswitch
                                            @elseif ($quantity > 1)
                                                @switch($catId)
                                                    @case(3)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'بکرے' : ($gender == 'female' ? 'بکریاں' : 'بکرے / بکریاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(4)
                                                        {{ $quantity }} بھیڑیں - {{ $breedName }}
                                                        @break
                                                    @case(6)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'کٹے' : ($gender == 'female' ? 'کٹیاں' : 'کٹے / کٹیاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(7)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'بچھڑے' : ($gender == 'female' ? 'بچھڑیاں' : 'بچھڑے / بچھڑیاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(8)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'گھوڑے' : ($gender == 'female' ? 'گھوڑیاں' : 'گھوڑے / گھوڑیاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(9)
                                                        {{ $quantity }} {{ $listing->title ?? '' }}
                                                        @break
                                                    @case(10)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'کتے' : ($gender == 'female' ? 'کتیا‌ئیں' : 'کتے / کتیا‌ئیں') }} - {{ $breedName }}
                                                        @break
                                                    @case(11)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'بلّے' : ($gender == 'female' ? 'بلیاں' : 'بلّے / بلیاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(12)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'طوطے' : ($gender == 'female' ? 'طوطیاں' : 'طوطے / طوطیاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(13)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'کبوتر' : ($gender == 'female' ? 'کبوتریاں' : 'کبوتر / کبوتریاں') }} - {{ $breedName }}
                                                        @break
                                                    @case(14)
                                                        {{ $quantity }} {{ $gender == 'male' ? 'مور' : ($gender == 'female' ? 'مورنیاں' : 'مور / مورنیاں') }} - {{ $breedName }}
                                                        @break
                                                    @default
                                                        {{ $quantity }} {{ $listing->category->name ?? '' }} - {{ $breedName }}
                                                @endswitch
                                            @endif
                                        </h3>
                                </a>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0 p-0 card-text">
                                    <span class="fw-bold h6">
                                        @if ($listing->total_price) PKR {{ number_format($listing->total_price) }}<br>
                                        @elseif ($listing->price) PKR {{ number_format($listing->price) }}<br>
                                        @else On call <Br> @endif
                                    </span>
                                </h6>
                                <i class="bi bi-eye text-hover"> <span>{{ $listing->interaction->view_count ?? 0 }}</span></i>
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
         @if(count($listings) > 8)
            <div class="text-center my-4">
                <button id="showMoreBtn" class="btn btn-primary px-4 py-3">
                    مزید دیکھیں
                </button>
            </div>
        @endif
    </div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const listings = document.querySelectorAll('.listing-item');

            // Hide all listings after the first 8
            for (let i = 8; i < listings.length; i++) {
                listings[i].style.display = 'none';
            }

            let currentVisible = 8;
            const totalListings = listings.length;

            const showMoreBtn = document.getElementById('showMoreBtn');

            if (showMoreBtn) {
                showMoreBtn.addEventListener('click', function () {
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

        function toggleHeart(button) {
            const userId = button.getAttribute('data-user');
            const listingId = button.getAttribute('data-listing');
            const icon = button.querySelector('i');

            console.log('User ID:', userId, 'Listing ID:', listingId);

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
                if (data.status === 'liked') {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    icon.classList.add('text-danger');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    icon.classList.remove('text-danger');
                }
            })
            .catch(() => {
                alert('Failed to like/unlike listing.');
            });
        }
    </script>


@endsection


