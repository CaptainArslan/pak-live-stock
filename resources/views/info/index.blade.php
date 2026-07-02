@extends('layouts.app')

@section('title', 'information - Pak Livestock')

@section('content')
<div class="container py-5">
    <!-- Heading -->
    <div class="text-center mb-5">
      <h2 class="text-dark" style="font-size: 25px; font-weight: 700;">تازہ ترین خبریں اور معلومات</h2>
    </div>

    <!-- Team Grid -->
    <div class="row g-4">
      <!-- Repeat this block for each team member -->
       @foreach ($informations as $info)
      <div class="col-12 col-sm-6 col-lg-3">
        <a href="#" class="text-decoration-none">
        <div class="team-card">
            @if ($info->image)
            <img src="{{ asset('storage/app/public/' . $info->image) }}" alt="Adam Lee">
            @endif
          <div class="team-overlay">
            <h6 class="mb-0 text-white">{{ $info->title }}</h6>
            <a href="{{ route('info.show', $info->id) }}"><button type="button" class="btn buttoncolor mt-3" style="background-color: white;">مزید پڑھیں </button></a>
          </div>
        </div>
    </a>
      </div>
      @endforeach
    </div>
  </div>
  
<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($informations->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $informations->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($informations->links()->elements[0] as $page => $url)
                    @if ($page == $informations->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($informations->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $informations->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endsection

