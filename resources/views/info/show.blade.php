@extends('layouts.app')
@section('title', $info->title . ' - Pak Livestock')
@section('content')


<div class="container urduContainer mt-5">
    <div class="row">
        
      <!-- Sidebar -->
        <div class="col-lg-3 mt-4 mt-lg-0">
          <div class="bg-white rounded shadow-sm mb-4">
            <h5 class="px-2 text-end" style="font-size: 1.2em; font-weight: 600;">حالیہ پوسٹس</h5>
            <ul class="list-unstyled text-muted">
              @foreach($recentInfos as $recent)
                <li>
                  <a href="{{ route('info.show', $recent->id) }}" class="px-2 text-end text-decoration-none text-muted text-hover d-block py-2 border-bottom">
                    {{ Str::limit($recent->title, 50) }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        
      <!-- Main Content -->
        <div class="col-lg-9">
        <div class="bg-white rounded shadow-sm">
            {{-- Image Section (Only if an image exists) --}}
            @if ($info->image)
                    <img src="{{ Storage::url($info->image) }}" alt="Blog Image" class="img-fluid blog-img mb-4">
            @endif
            
                    
            {{-- Title Section (Always Centered) --}}
            <h1 class="mb-3" style="font-size: 25px; font-weight: 700;">{{ $info->title }}</h1>
            <p class="text-muted mb-2">{{ date('d-m-Y', strtotime($info->updated_at)) }}</p>
            <p>
              {{-- Description (Only if it exists) --}}
                @if ($info->description)
                    {!! $info->description !!}
                @endif
            </p>
             {{-- Video Link (Only if it exists) --}}
            @if ($info->video_link)
                <div class="mb-4 text-center">
                    @php
                        $videoLink = $info->video_link;
                        // Convert watch?v= to embed/
                        if (strpos($videoLink, 'watch?v=') !== false) {
                            $embedLink = str_replace("watch?v=", "embed/", $videoLink);
                        } else {
                            $embedLink = $videoLink; // fallback
                        }
                    @endphp
                    
                    <iframe width="720" height="405" class="rounded border" src="{{ $embedLink }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif
        
            {{-- Uploaded Video (Only if it exists) --}}
            @if ($info->video_upload)
                <div class="mb-4 text-center">
                    <video width="720" height="405" class="rounded border" controls>
                        <source src="{{ Storage::url($info->video_upload) }}" type="video/mp4">
                    </video>
                </div>
            @endif
        </div>
          
      </div>

    </div>
  </div>

<!--<div class="container mt-4">-->

<!--    {{-- Image Section (Only if an image exists) --}}-->
<!--    @if ($info->image)-->
<!--        <div class="mb-4">-->
<!--            <img src="{{ Storage::url($info->image) }}" class="img-fluid w-100" style="max-height: 600px; object-fit: cover;">-->
<!--        </div>-->
<!--    @endif-->

<!--    {{-- Title Section (Always Centered) --}}-->
<!--    <h2 class="text-center my-4">{{ $info->title }}</h2>-->

<!--    {{-- Description (Only if it exists) --}}-->
<!--    @if ($info->description)-->
<!--        <div class="mb-4">-->
<!--            <p class="text-muted text-center">{!! $info->description !!}</p>-->
<!--        </div>-->
<!--    @endif-->

<!--    {{-- Video Link (Only if it exists) --}}-->
<!--    @if ($info->video_link)-->
<!--        <div class="mb-4 text-center">-->
<!--            <iframe width="720" height="405" class="rounded border" src="{{ $info->video_link }}" frameborder="0" allowfullscreen></iframe>-->
<!--        </div>-->
<!--    @endif-->

<!--    {{-- Uploaded Video (Only if it exists) --}}-->
<!--    @if ($info->video_upload)-->
<!--        <div class="mb-4 text-center">-->
<!--            <video width="720" height="405" class="rounded border" controls>-->
<!--                <source src="{{ Storage::url($info->video_upload) }}" type="video/mp4">-->
<!--            </video>-->
<!--        </div>-->
<!--    @endif-->

<!--</div>-->
@endsection
