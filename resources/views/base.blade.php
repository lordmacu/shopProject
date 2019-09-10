<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Ecommerce Example</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/query.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">

    </head>
    <body>
        <div id="app">

            <!--Page Wrapper starts-->
            <!--Preloader starts-->
            <div class="preloader js-preloader">
                <div class="dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
            <!--Preloader ends-->
            <!--Page Wrapper starts-->
            <div class="page-wrapper fixed-footer">
                <!--header starts-->
                <header class="header transparent scroll-hide">
                    <!--Main Menu starts-->
                    <div class="site-navbar-wrap v1">
                        <div class="container">
                            <div class="site-navbar">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-6">
                                        <a class="navbar-brand" href="#"><img src="{{asset("images/logo-white.png")}}" alt="logo" class="img-fluid"></a>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <nav class="site-navigation float-left">
                                            <div class="container">
                                                {{ menu('main', 'partials.menus.main') }}
                                            </div>
                                        </nav>
                                        <div class="d-lg-none sm-right">
                                            <a href="#" class="mobile-bar js-menu-toggle">
                                                <span class="ion-android-menu"></span>
                                            </a>
                                        </div>
                                        <div class="add-list float-right">
                                            <a class="btn v8" href="add-listing.html">Add Listing <i class="ion-plus-round"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--mobile-menu starts -->
                            <div class="site-mobile-menu">
                                <div class="site-mobile-menu-header">
                                    <div class="site-mobile-menu-close  js-menu-toggle">
                                        <span class="ion-ios-close-empty"></span>
                                    </div>
                                </div>
                                <div class="site-mobile-menu-body"></div>
                            </div>
                            <!--mobile-menu ends-->
                        </div>
                    </div>
                    <!--Main Menu ends-->
                </header>
           
                
            @yield('content')

            </div>
            <!--Page Wrapper ends-->
            <!--Footer Starts-->
            @include('partials.footer')

            

        </div>

        <!--plugin js-->
        <script src="{{ asset('js/app.js') }} "></script>
        <script src="{{ asset('js/plugin.js') }} "></script>
                @yield('extra-js')

        <script src="{{ asset('js/main.js') }} "></script>

         
    </body>
</html>
