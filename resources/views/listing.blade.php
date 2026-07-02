@extends('layouts.app')
@section('title', $listing->category->name . ' - Pak Livestock')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    li#primary_slider-slide01{background-size:contain !important;}
    .btn-outline-primary{border-color:#004614 !important; color:#004614!important}
    .btn-outline-primary:hover{background-color:#004614 !important; color:#fff !important}
    .swal-login-btn {
        background-color: #004614 !important;
        color: #fff !important;
    }
</style>

@section('content')

<div class="container py-4">
    <div class="row">
        <!--left image side-->
        <div class="col-lg-9 pe-md-3">
            <div class="card border-0">
                  <!-- Primary Slider -->
                <div id="primary_slider" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach(json_decode($listing->images) as $image)
                                <li class="splide__slide">
                                    <img src="{{ $image ? asset('storage/app/public/' . $image) : asset('/assets/images/listingImage.webp') }}" alt="Listing Image" class="w-100 h-auto">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Thumbnail Slider -->
                <div id="thumbnail_slider" class="splide splide--nav splide--nav-pag">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach(json_decode($listing->images) as $image)
                                <li class="splide__slide">
                                    <img src="{{ $image ? asset('storage/app/public/' . $image) : asset('/assets/images/listingImage.webp') }}" alt="Listing Image" class="w-100 h-auto">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="px-4">
                    <div class="">
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
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-muted text-hover" style="cursor: pointer;"><i class="bi bi-eye"></i> {{ $listing->interaction->view_count ?? 0 }}</p>
                        <div class="d-rtl">
                            <p class="text-muted mb-2"><i class="bi bi-geo-alt"></i> {{ $listing->address ?? '' }} {{ $listing->city ? $listing->city . ', ' : '' }} {{ $listing->province ? $listing->province . ', ' : '' }}  </p>
                        </div>
                    </div>
                    <h6 class="m-0 p-0 mb-2 text-end" style="font-size: 25px; font-weight: 700;">تفصیل</h6>
                    <p class="text-end text-muted" style="font-size: 17px; font-weight: 500;">  \
                        @if ($listing->detail)
                            {{ $listing->detail }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!--right listing info  side-->
        <div class="col-lg-3">
          <!-- Price and Actions -->
        <div class="card">
            <div class="px-3 pt-2 pb-2 text-center d-flex justify-content-center backgroundcolor align-items-center">

                    <p class="m-0 p-0 text-white text-center" style="font-size: 20px; font-weight: 700;">
                        @if ($listing->rate_on_call == 1)
                            قیمت کال پر
                        @elseif ($listing->total_price)
                           کل قیمت : {{ number_format($listing->total_price) }}
                        @elseif ($listing->price_per_animal)
                          قیمت فی جانور : {{ number_format($listing->price_per_animal) }}
                        @elseif ($listing->price_per_kg)
                            قیمت فی کلو : {{ number_format($listing->price_per_kg) }}
                        @elseif ($listing->price)
                           قیمت : {{ number_format($listing->price) }}
                        @else
                            قیمت کال پر
                        @endif
                    </p>

                    <!-- <p class="m-0 p-0 text-white pe-2" style="font-size: 15px; font-weight: 700;">: قیمت</p> -->

            </div>


            <div class="card p-2 border-0">
    <table class="table table-bordered text-end" dir="rtl">
        <tbody>
            <tr>
                <td colspan="2" class="text-center">
                    <p class="m-0 p-0" style="font-size: 25px; font-weight: 700;">خصوصیات</p>
                </td>
            </tr>

            <tr>
                <td class="text-muted" style="font-size: 14px; font-weight: 700;"> اشتہار کی آئی ڈی </td>
                <td class="text-color" style="font-size: 16px; font-weight: 700;">
                    {{ $listing->id }}
                </td>
            </tr>

            @if ($listing->quantity == 1)
            @if ($listing->age_years || $listing->age_months)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">عمر</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->age_years ? $listing->age_years . ' سال ' : '' }}
                        {{ $listing->age_months ? $listing->age_months . ' مہینے' : '' }}
                    </td>
                </tr>
            @endif
            @endif

            @if ($listing->height)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">قد</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->height ? $listing->height . ' انچ ' : '' }}
                    </td>
                </tr>
            @endif


            @if ($listing->quantity > 1)
                @if ($listing->min_age_years || $listing->min_age_months)
                    <tr>
                        <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم عمر</td>
                        <td class="text-color" style="font-size: 16px; font-weight: 700;">
                            {{ $listing->min_age_years ? $listing->min_age_years . ' سال ' : '' }}
                            {{ $listing->min_age_months ? $listing->min_age_months . ' مہینے' : '' }}
                        </td>
                    </tr>
                @endif

                @if ($listing->max_age_years || $listing->max_age_months)
                    <tr>
                        <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ عمر</td>
                        <td class="text-color" style="font-size: 16px; font-weight: 700;">
                            {{ $listing->max_age_years ? $listing->max_age_years . ' سال ' : '' }}
                            {{ $listing->max_age_months ? $listing->max_age_months . ' مہینے' : '' }}
                        </td>
                    </tr>
                @endif
            @endif

            {{-- Gender --}}
            @if (in_array($listing->category->id, [3, 4, 6, 7, 8, 10, 11, 12, 13, 14]))
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">جنس</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        @php
                            $genderText = 'نامعلوم';
                            if ($listing->gender === 'male') $genderText = 'نر';
                            elseif ($listing->gender === 'female') $genderText = 'مادہ';
                            elseif ($listing->gender === 'both') $genderText = 'نر و مادہ';
                        @endphp
                        {{ $genderText }}
                    </td>
                </tr>
            @endif

            {{-- گبھن only for female --}}
            @if (!is_null($listing->gaban) && in_array($listing->category->id, [1, 2]) )
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">گبھن</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->gaban == 'yes' ? 'ہاں' : 'نہیں' }}
                    </td>
                </tr>
            @endif

            @if ($listing->gender == 'female' && !is_null($listing->gaban))
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">گبھن</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->gaban == 'yes' ? 'ہاں' : 'نہیں' }}
                    </td>
                </tr>
            @endif

            {{-- خصی only for male and category 3 or 4 --}}
            @if ($listing->gender == 'male' && in_array($listing->category->id, [3, 4]) && !is_null($listing->khasi))
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">خصی</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->khasi == 'yes' ? 'ہاں' : 'نہیں' }}
                    </td>
                </tr>
            @endif

            @if ($listing->suwa)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">سوا</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->suwa }}</td>
                </tr>
            @endif

            @if ($listing->quantity)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">تعداد</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->quantity }}</td>
                </tr>
            @endif


            @if ($listing->category_id == 1 || $listing->category_id == 2)
            @if ($listing->milk_quantity)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">دودھ کی مقدار</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                        {{ $listing->milk_quantity }} لیٹر فی دن
                    </td>
                </tr>
            @endif
            @if (!$listing->milk_quantity)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;">دودھ کی مقدار</td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                         نہیں جانتے
                    </td>
                </tr>
            @endif

            @if (!$listing->sath_janwar)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;"> ساتھ جانور </td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                         کوئی بھی نہیں
                    </td>
                </tr>
            @endif

            @if ($listing->sath_janwar)
                <tr>
                    <td class="text-muted" style="font-size: 14px; font-weight: 700;"> ساتھ جانور </td>
                    <td class="text-color" style="font-size: 16px; font-weight: 700;">
                         {{ $listing->sath_janwar }}
                    </td>
                </tr>
            @endif

            @endif

            @php
                $teethLabels = [
                    0 => 'کوئی دانت نہیں',
                    1 => 'کھیرا',
                    2 => 'دو دانت',
                    4 => 'چار دانت',
                    6 => 'چھ دانت',
                    8 => 'آٹھ دانت',
                ];
            @endphp

            @if (in_array($listing->category_id, [3,4,5,6,7]))

                {{--  Teeth Section --}}
                {{-- Single Quantity --}}
                @if ($listing->quantity == 1)
                    @if (is_null($listing->teeth))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @elseif (isset($teethLabels[$listing->teeth]))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $teethLabels[$listing->teeth] }}</td>
                        </tr>
                    @endif
                @else
                    {{-- Multiple Quantity --}}
                    {{-- Min Teeth --}}
                    @if (is_null($listing->min_teeth))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @elseif (isset($teethLabels[$listing->min_teeth]))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $teethLabels[$listing->min_teeth] }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->min_teeth }} دانت</td>
                        </tr>
                    @endif

                    {{-- Max Teeth --}}
                    @if (is_null($listing->max_teeth))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @elseif (isset($teethLabels[$listing->max_teeth]))
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $teethLabels[$listing->max_teeth] }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ دانت</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->max_teeth }} دانت</td>
                        </tr>
                    @endif
                @endif

                {{--  Weight Section --}}
                @if ($listing->quantity == 1)
                    @if (is_null($listing->weight) || $listing->weight == 0)
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->weight }} کلوگرام</td>
                        </tr>
                    @endif
                @else
                    {{-- Min Weight --}}
                    @if (is_null($listing->min_weight) || $listing->min_weight == 0)
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">کم سے کم وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->min_weight }} کلوگرام</td>
                        </tr>
                    @endif

                    {{-- Max Weight --}}
                    @if (is_null($listing->max_weight) || $listing->max_weight == 0)
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">نہیں جانتے</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-muted" style="font-size: 14px; font-weight: 700;">زیادہ سے زیادہ وزن</td>
                            <td class="text-color" style="font-size: 16px; font-weight: 700;">{{ $listing->max_weight }} کلوگرام</td>
                        </tr>
                    @endif
                @endif

            @endif

        </tbody>
    </table>
</div>


            </div>
            <div class="card my-3 ">
                <div class="card-body text-center">
                      <!-- Owner Info -->
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="profile-img-placeholder mx-auto">
                                <img src="{{ asset('/assets/images/user.svg')}}" width="100%">
                            </div>
                            @if($listing->users->isNotEmpty())
                            <h6 class="mb-1">{{ $listing->users->first()->name }}</h6>
                            @endif
                            <span class="badge bg-success">لائیو اشتہارات </span> <br>
                            @if($listing->users->isNotEmpty())
                                @php $user = $listing->users->first(); @endphp
                                    @if ($user->id != 30)
                                        <a href="{{ route('userlisting', $user->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                            اس صارف کے مزید اشتہارات
                                        </a>
                                    @endif
                            @endif

                        </div>
                        <div class="container d-flex justify-content-between gap-2 mb-3">
                            @php
                                $isLoggedIn = auth('phoneUser')->check();
                            @endphp

                            <div class="btn-primary py-2 rounded" style="width: 100%">
                                <a href="tel:{{ $listing->contact_number }}"
                                   class="text-white contact-check"
                                   data-auth="{{ $isLoggedIn ? 'yes' : 'no' }}"
                                >
                                    <i class="bi bi-telephone-outbound-fill" style="font-size:24px"></i>
                                </a>
                            </div>

                            <div class="btn-primary py-2 rounded" style="width: 100%">
                                <a href="https://wa.me/92{{ $listing->contact_number }}"
                                   class="text-white contact-check"
                                   data-auth="{{ $isLoggedIn ? 'yes' : 'no' }}"
                                >
                                    <i class="bi bi-whatsapp" style="font-size:24px"></i>
                                </a>
                            </div>

                            <div class="btn-primary py-2 rounded" style="width: 100%">

                                <button class="btn-primary border-0 dropdown-toggle text-start" type="button" id="shareDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-share-fill"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="shareDropdown">
                                    <li><a id="shareClick" data-id="{{ $listing->id }}" class="dropdown-item text-start" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">Facebook &nbsp;&nbsp;<i class="bi bi-facebook"></i> </a></li>
                                    <li><a id="shareClick" data-id="{{ $listing->id }}" class="dropdown-item text-start" href="https://api.whatsapp.com/send?text={{ urlencode(request()->fullUrl()) }}" target="_blank">WhatsApp &nbsp;&nbsp; <i class="bi bi-whatsapp"></i> </a></li>
                                    <li><a id="shareClick" data-id="{{ $listing->id }}" class="dropdown-item text-start" href="#" onclick="copyLink('{{ request()->fullUrl() }}')">Copy Link &nbsp; &nbsp;<i class="bi bi-link-45deg"></i> </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Featured Listing Cards Grid -->
    <div class="container my-5 px-lg-5">
        <div class="d-flex justify-content-end mb-2">
          <h1 style="font-weight: 700;"> مزید اشتہارات </h1>
        </div>
        <div class="d-flex justify-content-between">
            <div class="pe-1 featured-button-prev d-flex justify-content-center align-items-center text-center">
            <i class="bi bi-arrow-left-square-fill fs-3 featured-button-prev"></i>
          </div>
            <!-- Swiper -->
            <div class="swiper myFeaturedSwiper d-flex justify-content-between" >

              <div class="swiper-wrapper">
                @foreach ($relatedListings as $listing)
                <div class="swiper-slide">
            <div class="card d-flex flex-column pb-1">
             @if($listing->images)
                @php $firstImage = json_decode($listing->images)[0] ?? null; @endphp
                <a href="{{ route('listing.show', $listing->id) }}" class="text-decoration-none">
                    <img
                        src="{{ $firstImage ? asset('storage/app/public/' . $firstImage) : asset('/assets/images/listingImage.webp') }}"
                        class="card-img-top"
                        alt="{{ $listing->category->name }}"
                        style="height: 150px; width: 100%; object-fit: cover; position:relative;" />
                </a>
            @endif

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
                    <p class="m-0 p-0 card-text">
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
                    </p>
                    <i class="bi bi-eye text-hover" style="cursor: pointer;"> <span>{{ $listing->interaction->view_count ?? 0 }}</span></i>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p class="m-0 p-0 card-text">{{ $listing->created_at->locale('en')->diffForHumans() }}</p>
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
            <div class="ps-1 featured-button-next d-flex justify-content-center align-items-center text-center">
              <i class="bi bi-arrow-right-square-fill fs-3"></i>
            </div>

        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Splide JS -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
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
    document.addEventListener('DOMContentLoaded', function () {
        var thumbnail = new Splide('#thumbnail_slider', {
            fixedWidth: 100,
            fixedHeight: 64,
            isNavigation: true,
            gap: 10,
            focus: 'center',
            pagination: false,
            cover: true,
            breakpoints: {
                600: {
                    fixedWidth: 66,
                    fixedHeight: 40,
                },
            },
        }).mount();

        var primary = new Splide('#primary_slider', {
            type: 'fade',
            heightRatio: 0.5,
            pagination: false,
            arrows: true,
            cover: true,
        });

        primary.sync(thumbnail).mount();
    });

    document.getElementById('contactBtn').addEventListener('click', function() {
    const listingId = this.dataset.id;
    fetch(`/listing/${listingId}/contact-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Click counted');
        } else {
            console.log('Already clicked or not logged in');
        }
    });
});
document.getElementById('shareClick').addEventListener('click', function() {
    const listingId = this.dataset.id;
    fetch(`/listing/${listingId}/share-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
    });

});
document.addEventListener("DOMContentLoaded", function () {
    const listingId = '{{ $listing->id }}'; // Pass your listing ID here

    fetch(`/listing/${listingId}/view`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
});

function copyLink(url) {
    navigator.clipboard.writeText(url).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        alert('Failed to copy: ', err);
    });

    // Optional: Fire share click API call
    const listingId = document.getElementById('shareClick').dataset.id;

    fetch(`/listing/${listingId}/share-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.contact-check');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            const isAuth = this.getAttribute('data-auth');

            if (isAuth === 'no') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'براہ کرم لاگ ان کریں',
                    text: 'رابطہ کرنے سے پہلے براہ کرم لاگ ان کریں۔',
                    showCancelButton: true,
                    confirmButtonText: 'لاگ ان',
                    cancelButtonText: 'اوکے',
                    customClass: {
                        confirmButton: 'swal-login-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/register-user';
                    }
                });
            }
        });
    });
});
</script>


@endsection
