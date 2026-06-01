@extends('layouts.sidebar')

@section('title', 'User Dashboard')
@section('sidebarContent')
<style>
    .liked-card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        padding: 40px 30px;
        margin-top: 60px;
    }
    .font-sm{ font-size:1em;}
</style>
 <div class="liked-card container my-5">
    <h2 class="text-center mb-4 fw-bold">میرے پوسٹ کردہ اشتہارات</h2>

    @if($listings->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($listings as $listing)
                <div class="col">
                    <div class="card shadow h-100">
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
                            <a href="{{ route('listing.show', $listing->id) }}" style="text-decoration:none;">
                                <h3 class="d-rtl p-0 text-hover text-black">
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
                            <p class="card-text d-flex justify-content-between text-end">
                                 {{ $listing->city }}<br>
                                <span class="fw-bold">
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

                            <div class="d-flex justify-content-between">
                                @if($listing->is_sold)
                                    <span class="badge bg-danger">فروخت شدہ</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center bg-light">
                            <form action="{{ route('listing.destroy', $listing->id) }}" method="POST" class="d-inline mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn font-sm">
                                    <i class="bi bi-trash" style="font-size:1em;"></i> &nbsp; ہٹائیں
                                </button>
                            </form>
                            @if($listing->category && $listing->category->main_cat === 'Pets')
                                <a href="{{ url('/phone-user/pet-edit/' . $listing->id) }}" class="btn btn-info btn-sm font-sm">اپ ڈیٹ</a>
                            @elseif($listing->category && $listing->category->main_cat === 'Birds')
                                <a href="{{ url('/phone-user/bird-edit/' . $listing->id) }}" class="btn btn-info btn-sm font-sm">اپ ڈیٹ</a>
                            @elseif($listing->category && $listing->category->main_cat === 'Other')
                                <a href="{{ url('/phone-user/other-edit/' . $listing->id) }}" class="btn btn-info btn-sm font-sm">اپ ڈیٹ</a>
                            @elseif($listing->category && $listing->category->main_cat === 'Livestock')
                                <a href="{{ url('/phone-user/edit/' . $listing->id) }}" class="btn btn-info btn-sm font-sm">اپ ڈیٹ</a>
                            @endif


                            @if(!$listing->is_sold)
                                <form action="{{ route('listings.markAsSold', $listing->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success mt-3 font-sm">مارک ایز سولڈ</button>
                                </form>
                            @endif
                            @if(!$listing->is_featured)
                                <a href="{{ route('featured.instructions', $listing->id) }}" class="btn btn-warning btn-sm font-sm">نمایاں کریں</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

                    <div class="d-flex justify-content-end mt-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($listings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $listings->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($listings->links()->elements[0] as $page => $url)
                                    @if ($page == $listings->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($listings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $listings->nextPageUrl() }}" rel="next">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>

    @else
        <div class="alert alert-info text-center mt-5">
            آپ نے ابھی تک کوئی اشتہار پوسٹ نہیں کیا۔
        </div>
    @endif
</div>

@endsection
