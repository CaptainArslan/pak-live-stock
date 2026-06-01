@extends ('layouts.app')
@section('content')

<style>
    .sidebar {
        width: 260px;
        background: #fff;
        border: 1px solid #004614;
        border-radius: 16px;
        padding: 25px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        float: right;
        direction: rtl;
    }

    .sidebar h3 {
        font-weight: bold;
        color: #004614;
        margin-bottom: 25px;
        border-bottom: 2px solid #004614;
        padding-bottom: 10px;
    }

    .dashboard {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .dashboard li {
        margin-bottom: 10px;
    }

    .dashboard li a {
        display: block;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.3s;
        color: #212529;
        font-weight: 500;
        background-color: #f8f9fa;
        text-decoration: none;
        font-size: 1.4em;
    }

    .dashboard li a:hover {
        background-color: #03b436;
        color: #fff;
    }
    .list-group-item.active{
        background-color: transparent;
        border: none;
    }
    .active a{
        background-color: #004614 !important;
        color: #fff !important;
    }

    .logoutb-btn {
        margin-top: 25px;
    }

    .logoutb-btn .btn {
        width: 100%;
        /*background-color: #004614;*/
        border: none;
        transition: 0.3s;
    }
     
    
</style>
<div class="comtainer">
    <div class="row">
        <div class="col-md-9">
            @yield('sidebarContent')    
        </div>
        
        <div class="col-md-3">
            
            <div class="sidebar shadow-lg my-5">
                <h3 class="text-center">ڈیش بورڈ</h3>
                <ul class="dashboard list-group">
                    <li class="list-group-item {{ Request::is('/') ? 'active' : '' }}">
                        <a href="/" class="text-decoration-none d-block"> ہوم </a>
                    </li>
                    <li class="list-group-item {{ Request::is('phone-user/dashboard') ? 'active' : '' }}">
                        <a href="/phone-user/dashboard" class="text-decoration-none d-block">ڈیش بورڈ</a>
                    </li>
                    <li class="list-group-item {{ Request::is('phone-user/profile') ? 'active' : '' }}">
                        <a href="/phone-user/profile" class="text-decoration-none d-block">پروفائل</a>
                    </li>
                    <li class="list-group-item {{ Request::is('phone-user/likedAds') ? 'active' : '' }}">
                        <a href="/phone-user/likedAds" class="text-decoration-none d-block">پسندیدہ اشتہارات</a>
                    </li>
                    <li class="list-group-item {{ Request::is('phone-user/posted-ads') ? 'active' : '' }}">
                        <a href="/phone-user/posted-ads" class="text-decoration-none d-block">شائع شدہ اشتہارات</a>
                    </li>
                    <li class="list-group-item {{ Request::is('phone-user/notifications') ? 'active' : '' }}">
                        <a href="/phone-user/notifications" class="text-decoration-none d-block">اطلاعات</a>
                    </li>
                </ul>
            
                <div class="logoutb-btn">
                    <form method="POST" action="{{ route('phone-user.logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">لاگ آؤٹ</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection