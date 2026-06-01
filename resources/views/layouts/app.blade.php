<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>@yield('title', 'Default Title - Pak Livestock')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/images/logo.webp') }}">
    <link rel="stylesheet" href="{{ asset('/css/frontstyle.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/jameel-noori@1.1.2/jameel-noori.min.css" rel="stylesheet">
    <style>
        body,
        * {
            font-family: JameelNooriNastaliq !important;
        }

        #floatingWhatsappBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            font-size: 24px;
            padding: 20px 8px;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        #floatingWhatsappBtn:hover {
            background-color: #1ebe5d;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>
    <div class="container-fluid backgroundcolor text-white text-center py-2 d-none d-md-flex justify-content-center"
        style="font-size: 1.2em; font-weight: 800;">
        جانوروں سے محبت کرنے والوں کے لیے ایک بہترین جگہ
    </div>
    <!-- Desktop View: md and up -->
    <div class="border-bottom px-md-5 py-md-2 d-none d-md-flex flex-wrap align-items-center justify-content-between">
        <!-- Logo -->
        <div class="col-md-1">
            <a href="/"><img src="{{ asset('/assets/images/logo.webp') }}" alt="logo" class="me-2"
                    style="width: 80px;"></a>
        </div>

        <!-- Navigation Links -->
        <div class="col-md-7 d-flex flex-wrap justify-content-center gap-5 text-center h4" style="font-weight: 700;">
            <a href="{{ route('home') }}" class="text-color text-hover text-decoration-none">ہوم</a>
            <!--<a href="{{ route('info.index') }}" class="text-color text-hover text-decoration-none"> استعمال کرنے کا طریقہ </a>-->
            <a href="{{ route('services') }}" class="text-color text-hover text-decoration-none">ہماری سروسز</a>

        </div>

        <!-- Account & Post Ad -->
        <div class="col-md-2 d-flex align-items-center justify-content-end">
            <div class="dropdown pe-2">
                <a href="{{ route('phone-user.dashboard') }}"><button class="btn btn-primary buttoncolor border-0"
                        style="font-size: 1.2em; font-weight: 700;">
                        اکاؤنٹ
                    </button></a>
            </div>

            <div>
                <a href="/preform" class="btn btn-outline-dark buttoncolor text-color  text-decoration-none"
                    style="font-size: 1.2em; font-weight: 700;">+ اشتہار لگائیں</a>
            </div>
        </div>
    </div>
    <!-- Mobile & Tablet View: sm and below -->
    <div class="container-fluid d-block d-md-none p-0">
        <!-- Banner -->
        <div class="backgroundcolor text-center text-white py-2" style="font-size: 1.2em; font-weight: 800;">
            جانوروں سے محبت کرنے والوں کے لیے ایک بہترین جگہ
        </div>

        <!-- Navbar -->
        <div class="d-flex align-items-center justify-content-between px-3 py-1">
            <!-- Menu Icon -->
            <i class="bi bi-list text-color text-hover fs-3" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                role="button"></i>
            <!-- Offcanvas Mobile Menu -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
                <div class="offcanvas-header">
                    <img src="{{ asset('/assets/images/logo.webp') }}" alt="logo" class="me-2"
                        style="width: 50px; height: 50px;">
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <!--<div class="px-2 input-group mb-2 border-bottom pb-2">-->
                <!--  <input type="text" class="form-control" placeholder="Search">-->
                <!--  <button class="btn backgroundcolor buttoncolor text-white">-->
                <!--    <i class="bi bi-search"></i>-->
                <!--  </button>-->
                <!--</div>-->

                <div class="offcanvas-body">
                    <nav class="d-flex flex-column gap-3 text-start" style="direction:rtl">
                        <a href="{{ route('home') }}"
                            class="text-color text-end text-hover text-decoration-none border-bottom pb-2"
                            style="font-size: 1.5em; font-weight: 700;">ہوم</a>
                        <!--<a href="{{ route('info.index') }}" class="text-color text-end text-hover text-decoration-none border-bottom pb-2"-->
                        <!--style="font-size: 1.5em; font-weight: 700;"> استعمال کرنے کا طریقہ </a>-->
                        <a href="{{ route('services') }}"
                            class="text-color text-end text-hover text-decoration-none border-bottom pb-2"
                            style="font-size: 1.5em; font-weight: 700;">ہماری سروسز</a>

                    </nav>
                    <div class="d-flex justify-content-between mt-4 gap-2">
                        @if (!auth('phoneUser')->check())
                            <div class="col backgroundcolor buttoncolor text-center border-0 rounded-2 px-3 py-1">
                                <a href="{{ route('phone-user.dashboard') }}"
                                    class="text-white text-center text-decoration-none"
                                    style="font-size: 1em; font-weight: 700;">لاگ ان</a>

                            </div>
                            <div class="col backgroundcolor buttoncolor text-center border-0 rounded-2 px-3 py-1">
                                <a href="{{ route('phone-user.dashboard') }}"
                                    class="text-white text-center text-decoration-none"
                                    style="font-size: 1em; font-weight: 700;">سائن اپ</a>
                            </div>
                        @else
                            <div class="col backgroundcolor buttoncolor text-center border-0 rounded-2 px-3 py-1">
                                <a href="{{ route('phone-user.dashboard') }}"
                                    class="text-white text-center text-decoration-none"
                                    style="font-size: 1em; font-weight: 700;">
                                    اکاؤنٹ
                                </a>
                            </div>
                            <div class="col backgroundcolor buttoncolor text-center border-0 rounded-2 px-3 py-1">
                                <form method="POST" action="{{ route('phone-user.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="btn-primary border-0 text-white text-center text-decoration-none"
                                        style="font-size: 1em; font-weight: 700;">لاگ آؤٹ</button>
                                </form>
                            </div>
                        @endif
                        <div class="col backgroundcolor buttoncolor text-center border-0 rounded-2 px-3 py-1">
                            <a href="/postads" class="text-white text-center text-center text-decoration-none"
                                style="font-size: 1em; font-weight: 700;">+ اشتہارلگائیں</a>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Brand -->
            <img src="{{ asset('/assets/images/logo.webp') }}" alt="logo" class="me-2"
                style="width: 80px;">

            <button class="backgroundcolor buttoncolor border-0 rounded-1 px-2 py-1">
                <a href="/postads" class="border-0 text-white text-decoration-none"
                    style="font-size: 1em; font-weight: 700;">+ اشتہار لگائیں</a>
            </button>
        </div>
    </div>









    <div class="container-fluid banner mb-lg-5 mb-md-2 ">
        @yield('content')
    </div>


    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="container-fluid p-0">

        <div class="container rounded mb-5">
            <a href="/">
                <img src="{{ asset('/assets/images/footbanner.webp') }}" class="img-fluid rounded-3"
                    alt="appdownload">
            </a>
        </div>

        <footer class="bg-light pt-3 text-center text-dark">
            <div class="col-12">
                <!--<img src="{{ asset('/assets/images/logo.webp') }}" alt="Gallery 1" style="width: 150px; height: 150px;" />-->
            </div>
            <!-- Grid container -->
            <div class="container p-4 pb-0">
                <!-- Section: Social media -->
                <section class="mb-4">
                    <!-- Facebook -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="#!" role="button"><i
                            class="bi bi-facebook"></i></a>

                    <!-- Twitter -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="#!" role="button"><i
                            class="bi bi-twitter"></i></a>

                    <!-- Instagram -->
                    <a class="btn btn-outline-dark btn-floating m-1" href="#!" role="button"><i
                            class="bi bi-instagram"></i></a>
                </section>
                <!-- Section: Social media -->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                Copyright © 2025 All Rights Reserved. Developed & Designed By <strong><a style="direction:ltr;"
                        href="https://www.weblypanda.com" class="text-black">Webly Panda</a> </strong>
            </div>
            <!-- Copyright -->
        </footer>

    </div>
    <!-- End of .container -->

    <!-- Floating Chat Button -->
    <div class="btn-primary py-2" id="floatingWhatsappBtn">
        <a href="https://wa.me/923488333127" class="text-white contact-check" style="margin: 5px;">
            <i class="bi bi-whatsapp" style="font-size:24px"></i>
        </a>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Example condition (you'd replace this with your real auth check)
        const isLoggedIn = true;

        document.addEventListener("DOMContentLoaded", function() {
            const loggedInOptions = document.getElementById("loggedInOptions");
            const notLoggedInOptions = document.getElementById("notLoggedInOptions");

            if (isLoggedIn) {
                loggedInOptions.style.display = "block";
                notLoggedInOptions.style.display = "none";
            } else {
                loggedInOptions.style.display = "none";
                notLoggedInOptions.style.display = "block";
            }
        });
    </script>

</body>

</html>
