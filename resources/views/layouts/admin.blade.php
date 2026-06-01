<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/logo.png') }}">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/app.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/bundles/chocolat/dist/css/chocolat.css') }}">
        <link rel="stylesheet" href="{{ asset('/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">

        <link rel="stylesheet" href="{{ asset('/bundles/summernote/summernote-bs4.css') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/logo.webp') }}">

        <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/components.css') }}">

        <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <style>body, *{  font-family: "Nunito", "Segoe UI", arial;}</style>
    </head>
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
              <div class="navbar-bg"></div>
              <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                  <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
        									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                    <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                        <i data-feather="maximize"></i>
                      </a></li>
                    <li>
                      <!--<form class="form-inline mr-auto">-->
                      <!--  <div class="search-element">-->
                      <!--    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">-->
                      <!--    <button class="btn" type="submit">-->
                      <!--      <i class="fas fa-search"></i>-->
                      <!--    </button>-->
                      <!--  </div>-->
                      <!--</form>-->
                    </li>
                  </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                  <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                      class="nav-link notification-toggle nav-link-lg"><img src="{{ asset('/assets/images/logo.png') }}"
                        class="user-img-radious-style" width="30px"> <span class="d-sm-none d-lg-inline-block">
                    </a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                      <!--<div class="dropdown-header">-->
                      <!--  Hello Sarah Smith-->
                      <!--</div>-->
                      <div class="dropdown-list-content dropdown-list-icons">
                        <a href="profile.html" class="dropdown-item has-icon"> <i class="far
        										fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button style="width:100%" type="submit">Logout</button>
                            </form>
                        </div>
                  </li>
                  <!--<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"-->
                  <!--    class="nav-link dropdown-toggle nav-link-lg nav-link-user">  <img src="{{ asset('/assets/images/logo.png') }}"-->
                  <!--      class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>-->
                  <!--  <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">-->
                  <!--    <div class="dropdown-title">Hello Sarah Smith</div>-->
                  <!--    <a href="profile.html" class="dropdown-item has-icon"> <i class="far-->
        										<!--fa-user"></i> Profile-->
                  <!--    </a> -->
                  <!--    <div class="dropdown-divider"></div>-->
                  <!--      <form method="POST" action="{{ route('logout') }}">-->
                  <!--          @csrf-->
                  <!--          <button style="width:100%" type="submit">Logout</button>-->
                  <!--      </form>-->
                  <!--  </div>-->
                  <!--</li>-->
                </ul>
              </nav>

              <!--sidebar -->

              <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                  <div class="sidebar-brand">
                    <a href="/admin">  <img src="{{ asset('/assets/images/logo.png') }}" class="header-logo" style="width:60px; height:60px" /> <span
                        class="logo-name">Live Stock</span>
                    </a>
                  </div>
                  <ul class="sidebar-menu">
                    <li class="dropdown">
                      <a href="/admin" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="/admin/categories" class="nav-link"><i class="fa-solid fa-layer-group"></i><span>Categories</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="/admin/breeds" class="nav-link"><i class="fa-solid fa-table-cells-large"></i><span>Breeds</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="{{ route('admin.listings.index') }}"><i class="fa-solid fa-table-cells-large"></i><span>All Listings</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa-solid fa-cow"></i><span>Live Stock Listings</span></a>
                      <ul class="dropdown-menu">
                           @if(isset($categories) && count($categories) > 0)
                            @foreach ($categories as $category)
                            @if ($category->main_cat == "Livestock")
                        <li><a class="nav-link" href="{{ route('admin.listings.index', ['category' => $category->id]) }}">
                             @if($category->image)
                              <img src="{{ Storage::url($category->image) }}" style="width:30px; height:30px; object-fit:cover;" class="rounded-circle">
                             @endif
                            &nbsp; &nbsp;<span class="d-none d-sm-inline">{{ $category->name }}</span>
                            </a></li>
                            @endif
                             @endforeach
                            @endif
                      </ul>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa-solid fa-cat"></i><span>Pets Listings</span></a>
                      <ul class="dropdown-menu">
                           @if(isset($categories) && count($categories) > 0)
                            @foreach ($categories as $category)
                            @if ($category->main_cat == "Pets")
                        <li><a class="nav-link" href="{{ route('admin.listings.index', ['category' => $category->id]) }}">
                             @if($category->image)
                              <img src="{{ Storage::url($category->image) }}" style="width:30px; height:30px; object-fit:cover;" class="rounded-circle">
                             @endif
                            &nbsp; &nbsp;<span class="d-none d-sm-inline">{{ $category->name }}</span>
                            </a></li>
                            @endif
                             @endforeach
                            @endif
                      </ul>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa-solid fa-dove"></i><span>Birds Listings</span></a>
                      <ul class="dropdown-menu">
                           @if(isset($categories) && count($categories) > 0)
                            @foreach ($categories as $category)
                            @if ($category->main_cat == "Birds")
                        <li><a class="nav-link" href="{{ route('admin.listings.index', ['category' => $category->id]) }}">
                             @if($category->image)
                              <img src="{{ Storage::url($category->image) }}" style="width:30px; height:30px; object-fit:cover;" class="rounded-circle">
                             @endif
                            &nbsp; &nbsp;<span class="d-none d-sm-inline">{{ $category->name }}</span>
                            </a></li>
                            @endif
                             @endforeach
                            @endif
                      </ul>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa-solid fa-table-list"></i><span>Other Listings</span></a>
                      <ul class="dropdown-menu">
                           @if(isset($categories) && count($categories) > 0)
                            @foreach ($categories as $category)
                            @if ($category->main_cat == "Other")
                        <li><a class="nav-link" href="{{ route('admin.listings.index', ['category' => $category->id]) }}">
                             @if($category->image)
                              <img src="{{ Storage::url($category->image) }}" style="width:30px; height:30px; object-fit:cover;" class="rounded-circle">
                             @endif
                            &nbsp; &nbsp;<span class="d-none d-sm-inline">{{ $category->name }}</span>
                            </a></li>
                            @endif
                             @endforeach
                            @endif
                      </ul>
                    </li>

                    <li class="dropdown">
                      <a href="/admin/phone-users" class="nav-link"><i class="fa-solid fa-user"></i><span>Users</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="/admin/informations" class="nav-link"><i class="fa-solid fa-database"></i><span>Informations</span></a>
                    </li>
                    <li class="dropdown">
                      <a href="/admin/featured-requests" class="nav-link"><i class="fa-solid fa-comments"></i><span>Ads Requests</span></a>
                    </li>

                  </ul>
                </aside>
              </div>
              <!-- Main Content -->
              <div class="main-content">

                            @yield('content')
              </div>
              <footer class="main-footer">
                <div class="footer-right">
                  <span>Developed & Designed By </span><a href="https://weblypanda.com" target="_blank">Usama</a></a>
                </div>
              </footer>
            </div>
          </div>
         </div>

        <script src="{{asset('/js/app.min.js') }}"></script>
          <!-- JS Libraies -->
        <script src="{{asset('/bundles/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
        <script src="{{asset('/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
          <!-- Page Specific JS File -->
          <!-- Template JS File -->
        <script src="{{ asset('/js/scripts.js') }}"></script>
          <!-- Custom JS File -->
        <script src="{{ asset('/js/custom.js') }}"></script>
          <!-- JS Libraies -->
        <script src="{{ asset('/bundles/apexcharts/apexcharts.min.js') }}"></script>
          <!-- Page Specific JS File -->
        <!--<script src="{{ asset('/js/page/index.js') }}"></script>-->
        <script src="{{ asset('/js/page/chart-apexcharts.js') }}"></script>


<script src="{{ asset('/bundles/summernote/summernote-bs4.js') }}"></script>


    </body>
</html>
