<div class="container my-5 px-lg-5">
    <div class="d-flex justify-content-between mb-2">
        <a href="{{ route($listingRoute, ['category' => $category->id]) }}"
            class="btn btn-primary shadow-lg px-4 py-0 border-0"
            style="font-weight: 700; line-height: 0px; padding-top:25px !important;">
            تمام اشتہارات
        </a>

        <h1 style="font-weight: 700;">{{ $category->name }} </h1>
    </div>
    <div class="d-flex justify-content-between">
        <div
            class="pe-1 swiper-button-prev-{{ $index }} d-flex justify-content-center align-items-center text-center">
            <i class="bi bi-arrow-left-square-fill fs-3 swiper-button-prev-{{ $index }}"></i>
        </div>
        <div class="swiper myCowSwiper myCowSwiper-{{ $index }} d-flex justify-content-between">
            <div class="swiper-wrapper">

                @foreach ($category->listings->where('is_sold', false)->sortByDesc('created_at') as $listing)
                    <div class="swiper-slide">
                        <div class="card d-flex flex-column pb-1">
                            <div style="position: relative;">
                                @php
                                    $images = is_array($listing->images)
                                        ? $listing->images
                                        : json_decode($listing->images, true) ?? [];
                                    $firstImage = $images[0] ?? null;
                                @endphp
                                @if ($firstImage)
                                    <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                                        <img src="{{ asset('storage/app/public/' . $firstImage) }}" class="card-img-top"
                                            alt="{{ $listing->category->name }}"
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
                                    <button onclick="toggleHeart(this)"
                                        class="mb-2 text-dark fs-5 border-0 bg-transparent"
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
                                    <p class="m-0 p-0 card-text">
                                        <span class="fw-bold h6">
                                            @if ($listing->rate_on_call == 1)
                                                قیمت کال پر
                                            @elseif ($listing->total_price)
                                                RS. {{ number_format($listing->total_price) }}
                                            @elseif ($listing->price_per_animal)
                                                RS. {{ number_format($listing->price_per_animal) }}
                                            @elseif ($listing->price_per_kg)
                                                RS. {{ number_format($listing->price_per_kg) }}
                                            @elseif ($listing->price)
                                                RS. {{ number_format($listing->price) }}
                                            @else
                                                قیمت کال پر
                                            @endif
                                        </span>
                                    </p>
                                    <i class="bi bi-eye text-hover" style="cursor: pointer;">
                                        <span>{{ $listing->interaction->view_count ?? 0 }}</span></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="m-0 p-0 card-text">
                                        {{ $listing->created_at->locale('en')->diffForHumans() }}</p>
                                    <h4 class="m-0 p-0 card-text text-hover" style="cursor: pointer;">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $listing->city }}
                                    </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div
            class="ps-1 swiper-button-next-{{ $index }} d-flex justify-content-center align-items-center text-center">
            <i class="bi bi-arrow-right-square-fill fs-3"></i>
        </div>
    </div>
</div>
