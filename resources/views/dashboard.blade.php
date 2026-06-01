@extends('layouts.admin')
<style>
    .banner-img{
        width: 140px !important;
        height: 140px!important;
        object-fit: contain;
    }
</style>
@section('content')
<div class="section">
    <!--<h1 class="text-primary fw-bold">Dashboard</h1>-->

    <div class="row justify-content-center">
        <!--users-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Total Users</h5>
                      <h2 class="mb-3 font-32">{{ $userCount }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/1.png') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Listing-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Total Listing</h5>
                      <h2 class="mb-3 font-32">{{ $totalListings }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/listing.webp') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--categories-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Total Categories</h5>
                      <h2 class="mb-3 font-32">{{ $totalCategories }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/categories.webp') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--breeds-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Total Breeds</h5>
                      <h2 class="mb-3 font-32">{{ $totalBreeds }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/breed.webp') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Approved-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Approved Ads</h5>
                      <h2 class="mb-3 font-32">{{ $approvedAds }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/adAprove.webp') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--Rejected-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Rejected Ads</h5>
                      <h2 class="mb-3 font-32">{{ $rejectedAds }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/adReject.webp') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--pending-->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Pending Ads</h5>
                      <h2 class="mb-3 font-32">{{ $pendingAds }}</h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="{{ asset('/assets/images/3.png') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!--Charts-->
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-6">
          <div class="card ">
            <div class="card-header">
              <h4>Click chart</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-9">
                    <!--getting chart1-->
                  <div id="chart1Here"></div>
                </div>
                <div class="col-lg-3">
                  <div class="row mt-5">
                    <div class="col-7 col-xl-7 mb-3">Total Share</div>
                    <div class="col-5 col-xl-5 mb-3">
                      <span class="text-big">{{ $totalShareClicks }}</span>
                    </div>
                    <div class="col-7 col-xl-7 mb-3">Total views</div>
                    <div class="col-5 col-xl-5 mb-3">
                      <span class="text-big">{{ $totalViews }}</span>
                    </div>
                    <div class="col-7 col-xl-7 mb-3">Total contacts</div>
                    <div class="col-5 col-xl-5 mb-3">
                      <span class="text-big">{{ $totalContactClicks }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Recent Registrations -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Recent Registrations</h4>
              </div>
              <div class="card-body py-0 table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Sr #</th>
                      <th scope="col">Name</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($recentUsers as $index => $user)
                    <tr>
                     <th>{{ $index + 1 }}</th>
                     <td>{{ $user->name }}</td>
                     <td>{{ $user->phone }}</td>
                     <td>
                        <span class="badge bg-success text-white">Approved</span> {{-- You can update this based on status if available --}}
                     </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
    const views = @json(array_values($viewsByMonth));
    const contacts = @json(array_values($contactsByMonth));
    const shares = @json(array_values($sharesByMonth));
</script>




@endsection
