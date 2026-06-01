@extends('layouts.sidebar')
@section('title', 'User Profile')
@section('sidebarContent')
    <style>

        .liked-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            padding: 40px 30px;
            margin-top: 60px;
        }


        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .carousel-image {
            height: 60px;
            width: 60px;
            object-fit: cover;
            margin: 2px;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .empty-message {
            font-size: 20px;
            color: #6c757d;
            margin-top: 20px;
        }
        .table-dark{
            --bs-table-bg: #db0505 !important;
        }
    </style>

<div class="container my-5 px-lg-5">
    <div class="text-center mb-4">
        <h2>آپ کے پسندیدہ اشتہارات</h2>
        @if ($likedListings->isEmpty())
            <p class="text-center empty-message">!آپ نے ابھی تک کوئی اشتہار پسند نہیں کیا</p>
        @endif
    </div>

    <div class="row">
        @foreach ($likedListings as $index => $listing)
        <div class="m-0 p-0 p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-1 listing-item">
            <div class="card d-flex flex-column pb-1">
                <div style="position: relative;">
                    @if($listing->images)
                        @php $firstImage = json_decode($listing->images)[0] ?? null; @endphp
                        <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                            <img
                                src="{{ $firstImage ? Storage::url($firstImage) : asset('/assets/images/listingImage.webp') }}"
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
                            onclick="removeLike({{ $listing->id }})"
                            class="mb-2 text-dark fs-5 border-0 bg-transparent"
                            style="cursor: pointer;"
                            title="ناپسند">
                            <i class="bi bi-heart-fill text-danger"></i>
                        </button>

                        <a href="{{ route('listing.show', $listing->id) }}" class="btn btn-warning btn-sm">دیکھیں</a>
                    </div>

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

                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 p-0">
                            <strong>
                                @if ($listing->total_price) PKR {{ number_format($listing->total_price) }}
                                @elseif ($listing->price) PKR {{ number_format($listing->price) }}
                                @else فون پر رابطہ کریں
                                @endif
                            </strong>
                        </h6>
                        <i class="bi bi-eye text-hover"> <span>{{ $listing->interaction->view_count ?? 0 }}</span></i>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="m-0 p-0">{{ $listing->created_at->locale('en')->diffForHumans() }}</p>
                        <p class="m-0 p-0"><i class="bi bi-geo-alt-fill"></i> {{ $listing->city }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function removeLike(listingId) {
        fetch(`/listing/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                user_id: {{ auth('phoneUser')->id() }},
                listing_id: listingId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'unliked') {
                Swal.fire({
                    icon: 'info',
                    title: 'Removed from Liked',
                    text: 'You have unliked this listing.',
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    location.reload();  // Refresh after showing the alert
                }, 1500); // Wait for alert to finish
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Failed to unlike the listing.',
            });
        });
    }


</script>

@endsection
