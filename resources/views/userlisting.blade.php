@extends('layouts.app')
@section('title', 'User Listings - Pak Livestock')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 col-md-2 pt-2">
           <!-- Owner Info -->

            <div class="card my-5 ">
                <div class="card-body text-center">
                    <div class="profile-img-placeholder mx-auto">
                        <img src="{{ asset('/assets/images/user.svg')}}" width="100%">
                    </div>
                    <h3 class="mb-1">{{ $user->name }} </h3>
                    <span class="badge bg-success my-2">لائیو اشتہارات </span>

                    <div class="container d-flex justify-content-between gap-2 my-3">
                        @php
                            $isLoggedIn = auth('phoneUser')->check();
                        @endphp

                        <div class="btn-primary py-2 rounded" style="width: 100%">
                            <a href="tel:{{ $user->phone }}"
                               class="text-white contact-check"
                               data-auth="{{ $isLoggedIn ? 'yes' : 'no' }}"
                            >
                                <i class="bi bi-telephone-outbound-fill" style="font-size:24px"></i>
                            </a>
                        </div>

                        <div class="btn-primary py-2 rounded" style="width: 100%">
                            <a href="https://wa.me/92{{ $user->phone }}"
                               class="text-white contact-check"
                               data-auth="{{ $isLoggedIn ? 'yes' : 'no' }}"
                            >
                                <i class="bi bi-whatsapp" style="font-size:24px"></i>
                            </a>
                        </div>
                    </div>

                </div>

        </div>
        </div>
        <div class="col-md-10 col-12">
            <div class="container">
                <div class="row">
                     <!-- Product Cards Grid -->
                    <div class="container my-5 px-lg-5">
                        <div class="row">
                            @php
                              $sortedListings = $listings->sortByDesc(function ($listing) {
                                  return [$listing->is_featured, $listing->updated_at];
                              });
                            @endphp
                            @foreach ($sortedListings as $index => $listing)
                            <div class="m-0 p-0 p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-1 listing-item">
                                <div class="card d-flex flex-column pb-1">
                                    <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                                        @php
                                            $firstImage = $listing->images ? json_decode($listing->images)[0] ?? null : null;
                                        @endphp
                                        <img
                                            src="{{ $firstImage ? asset('storage/app/public/' . $firstImage) : asset('/assets/images/listingImage.webp') }}"
                                            class="card-img-top"
                                            alt="Listing Image"
                                            style="height: 150px; width: 100%; object-fit: cover;" />
                                    </a>
                                    @if($listing->is_featured)
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0"
                                      style="transform: rotate(320deg); transform-origin: left top; margin-top: 40px;">
                                      Featured
                                    </span>
                                    @endif
                                    <div class="card-body">
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
                                <button id="showMoreBtn" class="btn btn-primary h4 px-4 py-3">
                                    مزید دیکھیں
                                </button>
                            </div>
                        @endif
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const listings = document.querySelectorAll('.listing-item');

                            // Hide all listings after the first 8
                            for (let i = 8; i < listings.length; i++) {
                                listings[i] && (listings[i].style.display = 'none');
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
                    </script>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.contact-check');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            const isAuth = this.getAttribute('data-auth');

            if (isAuth === 'no') {
                e.preventDefault(); // Block link
                Swal.fire({
                    icon: 'warning',
                    title: 'براہ کرم لاگ ان کریں',
                    text: 'رابطہ کرنے سے پہلے براہ کرم لاگ ان کریں۔',
                    confirmButtonText: 'اوکے'
                });
            }
        });
    });
});
</script>

@endsection
