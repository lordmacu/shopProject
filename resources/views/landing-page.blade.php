@extends('base')


@section('content')





<!--header starts-->
<header class="header transparent scroll-hide">
    <!--Main Menu starts-->
    <div class="site-navbar-wrap v1">
        <div class="container">
            <div class="site-navbar">
                <div class="row align-items-center">
                    <div class="col-md-4 col-6">
                        <a class="navbar-brand" href="#"><img src="images/logo-white.png" alt="logo" class="img-fluid"></a>
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
<!--Header ends-->
<!--Hero section starts-->
<div class="hero v1 section-padding bg-zoom">
    <div class="overlay op-3"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="hero__title places-tab">
                    What's Your Plan Today ?
                </h1>
                <h1 class="hero__title events-tab">
                    Explore great events.
                </h1>
                <p class="hero__description">
                    All the top locations – from restaurants and clubs, to galleries, famous places and more..
                </p>
            </div>
            <div class="col-md-12 text-center mar-top-20">
                <ul class="hero__list">
                    <li class="hero__list-item">
                        <a class="place active-list" href="#">Places <i class="icofont-google-map" aria-hidden="true"></i></a>
                    </li>
                    <li class="hero__list-item">
                        <a class="events" href="#">Events<i class="icofont-list"></i></a>
                    </li>
                </ul>
                <form class="hero__form v1 bg-white">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <input class="hero__form-input custom-select" type="text" name="place-event" id="place-event" placeholder="What are you looking for?" />

                        </div>
                        <div class="col-lg-3 col-md-12">
                            <select class="hero__form-input custom-select">
                                <option>Select Location </option>
                                <option>New York</option>
                                <option>California</option>
                                <option>Washington</option>
                                <option>New Jersey</option>
                                <option>Los Angeles</option>
                                <option>Florida</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <select class="hero__form-input custom-select">
                                <option>Select Categories</option>
                                <option>Art's</option>
                                <option>Health</option>
                                <option>Hotels</option>
                                <option>Real Estate</option>
                                <option>Rentals</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <div class="submit_btn text-right md-left">
                                <button class="btn v3 text-right" type="submit"><i class="ion-search" aria-hidden="true"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Hero section ends-->
<!--Promo Category starts-->
<div class="hero-catagory mar-top-30 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-catagory-wrapper v1">
                    @foreach($categories as $category)
                    <a href="grid-fullwidth.html" class="hero-category-content v1">
                        <i class="{{$category->icon}}"></i>
                        <p class="name">{{$category->name}}</p>
                        <p class="d-name">{{$category->products_count}} Locations</p>
                    </a>
                    @endforeach
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!--Promo Category ends-->
<!--Popular City starts-->
<div class="popular-cities section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">Explore Your Dream Places</h2>
            </div>
            <div class="col-md-12">
                <div class="swiper-container popular-place-wrap">
                    <div class="swiper-wrapper">
                        @foreach($regions as $region)
                        <div class="swiper-slide popular-item">
                            <div class="single-place">
                                <img class="single-place-image" src="{{Voyager::image($region->thumbnail('feature', 'image'))}}" alt="place-image">
                                <div class="single-place-content">
                                    <h2 class="single-place-title">
                                        <a href="grid-fullwidth-map.html">{{$region->name}}</a>
                                    </h2>
                                    <ul class="single-place-list">
                                        <li><span>{{$region->cities->count()}}</span> Regiones</li>
                                        <li><span>{{countProductRegins($region->cities)}}</span> Listing</li>
                                    </ul>
                                    <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="slider-btn v1 popular-next"><i class="ion-arrow-right-c"></i></div>
                <div class="slider-btn v1 popular-prev"><i class="ion-arrow-left-c"></i></div>
            </div>
        </div>
    </div>
</div>
<!--Popular City ends-->
<!--Trending events starts-->
<div class="trending-places section-padding pad-bot-130">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">Los mejores Toures</h2>
                
            </div>
            <div class="col-md-12">
                <div class="swiper-container trending-place-wrap">
                    <div class="swiper-wrapper">
                      
                       
                         @foreach ($products as $product)
                          <div class="swiper-slide trending-place-item">
                            <div class="trending-img">
                                <img src="{{Voyager::image($product->thumbnail('mobile', 'image'))}}" alt="#">
                                <span class="trending-rating-orange">{{$product->id}}</span>
                                <span class="save-btn"><i class="icofont-heart"></i></span>
                            </div>
                            <div class="trending-title-box">
                                <h4><a href="{{ route('country.shop.show',[\Session::get('country')->slug,$product->slug] ) }}">{{$product->name}}</a></h4>
                               <!-- <div class="customer-review">
                                    <div class="rating-summary float-left">
                                        <div class="rating-result" title="60%">
                                            <ul class="product-rating">
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star-half"></i></li>
                                                <li><i class="ion-android-star-half"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="review-summury float-right">
                                        <p><a href="#">3 Reviews</a></p>
                                    </div>
                                </div>-->
                                @if($product->organizator)<ul class="trending-address">
                                    <li><i class="ion-ios-location"></i>
                                    
                                        <p>{{$product->organizator->name}}</p>
                                    </li>
                                   
                                    <li><i class="ion-android-globe"></i>
                                        <p>{{$product->organizator->address}}</p>
                                    </li>
                                </ul>
                                @endif
                                <div class="trending-bottom mar-top-15 pad-bot-30">
                                    <div class="trend-left float-left">
                                        <span class="round-bg green"><i class="{{$product->categories[0]->icon}}"></i></span>
                                        <p><a href="#">{{$product->categories[0]->name}}</a></p>
                                    </div>
                                    <div class="trend-right float-right">
                                        <div class="trend-open mar-top-5"><i class="icofont-price"></i>{{$product->price}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         @endforeach
                    </div>
                </div>
                <div class="trending-pagination"></div>
            </div>
        </div>
    </div>
</div>
<!--Trending events ends-->
<!--Popular Category starts
<div class="popular-catagory pad-bot-50 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">Explore What To do</h2>
            </div>
            <div class="col-md-4">
                <a href="grid-fullwidth.html">
                    <div class="popular-catagory-content">
                        <div class="popular-catagory-img">
                            <img src="images/category/cat-1.jpg" alt="hotel" class="img_fluid">
                        </div>
                        <div class="cat-content">
                            <h4 class="title">Hotel</h4>
                            <span>23 Listings</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <a href="grid-fullwidth.html">
                    <div class="popular-catagory-content">
                        <div class="popular-catagory-img">
                            <img src="images/category/cat-2.jpg" alt="hotel" class="img_fluid">
                        </div>
                        <div class="cat-content">
                            <h4 class="title">Shopping</h4>
                            <span>15 Listings</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <a href="grid-fullwidth.html">
                    <div class="popular-catagory-content">
                        <div class="popular-catagory-img">
                            <img src="images/category/cat-3.jpg" alt="restaurent" class="img_fluid">
                        </div>
                        <div class="cat-content">
                            <h4 class="title">Eat &amp; Drink</h4>
                            <span>34 Listings</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="grid-fullwidth.html">
                    <div class="popular-catagory-content">
                        <div class="popular-catagory-img">
                            <img src="images/category/cat-4.jpg" alt="hotel" class="img_fluid">
                        </div>
                        <div class="cat-content">
                            <h4 class="title">Travel</h4>
                            <span>20 Listings</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
-->
<!--Popular Category ends-->
<!--Trending Place starts-->
<div class=" section-padding pad-bot-130">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">Los mejores Eventos</h2>
            </div>
            <div class="col-md-12">
                <div class="swiper-container trending-place-wrap">
                    <div class="swiper-wrapper">
                          @foreach ($events as $product)
                        <div class="swiper-slide trending-place-item">
                            <div class="trending-img">
                                <img src="{{Voyager::image($product->thumbnail('mobile', 'image'))}}" alt="#">
                                <span class="trending-rating-green">7</span>
                                <span class="save-btn"><i class="icofont-heart"></i></span>
                            </div>
                            <div class="trending-title-box">
                                <h4><a href="single-listing-one.html">{{$product->name}}</a></h4>
                               <!--- <div class="customer-review">
                                    <div class="rating-summary float-left">
                                        <div class="rating-result" title="60%">
                                            <ul class="product-rating">
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star"></i></li>
                                                <li><i class="ion-android-star-half"></i></li>
                                                <li><i class="ion-android-star-half"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="review-summury float-right">
                                        <p><a href="#">3 Reviews</a></p>
                                    </div>
                                </div>-->
                                  @if($product->organizator)<ul class="trending-address">
                                    <li><i class="ion-ios-location"></i>
                                    
                                        <p>{{$product->organizator->name}}</p>
                                    </li>
                                   
                                    <li><i class="ion-android-globe"></i>
                                        <p>{{$product->organizator->address}}</p>
                                    </li>
                                </ul>
                                @endif
                                <div class="trending-bottom mar-top-15 pad-bot-30">
                                    <div class="trend-left float-left">
                                        <span class="round-bg pink"><i class="{{$product->categories[0]->icon}}"></i></span>
                                        <p><a href="#">{{$product->categories[0]->name}}</a></p>

                                    </div>
                                    <div class="trend-right float-right">
                                        <div class="trend-open">
                                            <div class="trend-open mar-top-5"><i class="icofont-price"></i>{{$product->price}}</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       @endforeach
                    </div>
                </div>
                <div class="trending-pagination"></div>
            </div>
        </div>
    </div>
</div>
<!--Trending Place ends-->
<!--Coupon starts-->
<div class="coupon-section section-padding">
    <div class="container ">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1"> Coupons &amp; Deals</h2>
            </div>
            <div class="col-md-12">
                <div class="swiper-container coupon-wrap">
                    <div class="swiper-wrapper pad-bot-15">
                        <div class="swiper-slide coupon-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="coupon-img">
                                        <img class="img-fluid" src="images/category/coupon/3.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="coupon-desc float-right">
                                        <h4>30% Discount</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="coupon-owner mar-top-20">
                                        <a href="single-listing-one.html">Favola Restaurant</a>
                                        <a href="#" class="rating">
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star-half"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                            Get Coupon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide coupon-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="coupon-img">
                                        <img class="img-fluid" src="images/category/coupon/5.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="coupon-desc float-right">
                                        <h4>20% Off</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="coupon-owner mar-top-20">
                                        <a href="single-listing-one.html">Orion Spa</a>
                                        <a href="#" class="rating">
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star-half"></i>
                                            <i class="ion-android-star-half"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                            Get Coupon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide coupon-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="coupon-img">
                                        <img class="img-fluid" src="images/category/coupon/4.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="coupon-desc float-right">
                                        <h4>25% Discount</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="coupon-owner mar-top-20">
                                        <a href="single-listing-one.html">Hotel La Muro</a>
                                        <a href="#" class="rating">
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star-half"></i>
                                            <i class="ion-android-star-half"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                            Get Coupon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide coupon-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="coupon-img">
                                        <img class="img-fluid" src="images/category/coupon/1.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="coupon-desc float-right">
                                        <h4>50% OFF</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="coupon-owner mar-top-20">
                                        <a href="single-listing-one.html">Penguin Shop</a>
                                        <a href="#" class="rating">
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star-half"></i>
                                            <i class="ion-android-star-half"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                            Get Coupon
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="slider-btn v1 coupon-next"><i class="ion-arrow-right-c"></i></div>
                <div class="slider-btn v1 coupon-prev"><i class="ion-arrow-left-c"></i></div>
                <div class="modal fade" id="coupon_wrap">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Get a Coupon</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="ion-ios-close-empty"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-coupon-code">
                                    <div class="store-content">
                                        <div class="text">
                                            Stores :
                                            <span> La Poma ,</span>
                                            <span>Gucci</span>
                                        </div>
                                        <div class="store-content">Cashback : <span>25% cashback </span></div>
                                        <div class="store-content">Valid till : <span>25-5-2019 </span></div>
                                        <div class="cashback-text">
                                            <p>Cashback will be added in your wallet in next 5 Minute of your purchase.</p>
                                        </div>
                                    </div>
                                    <div class="coupon-code">
                                        <h5>
                                            Coupon Code: <span class="coupon-code-wrapper">
                                                <i class="fa fa-scissors"></i>
                                                12345
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="coupon-bottom">
                                <div class="float-left"><a href="single-listing-one.html" class="btn v1">Go to Deal</a></div>
                                <button type="button" class="btn v1 float-right" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Coupon ends-->
<!--mobile app start
<div class="app-section section-padding pad-top-70" style="background-image: url(images/bg/bg2.png)">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="app-content">
                    <h2>Looking for the Best Service Provider? <span>Get the App!</span></h2>
                    <ul>
                        <li><i class="ion-android-checkbox-outline" aria-hidden="true"></i> Find nearby listings</li>
                        <li><i class="ion-android-checkbox-outline" aria-hidden="true"></i> Easy service enquiry</li>
                        <li><i class="ion-android-checkbox-outline" aria-hidden="true"></i> Listing reviews and ratings</li>
                        <li><i class="ion-android-checkbox-outline" aria-hidden="true"></i> Manage your listing, enquiry and reviews</li>
                    </ul>
                    <div class="device-logo mar-top-40 xs-center">
                        <a href="#"><img src="images/others/android.png" alt="..."> </a>
                        <a href="#"><img src="images/others/apple.png" alt="..."> </a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="app-img text-center">
                    <img src="images/others/app-image-1.png" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!--mobile app ends-->
<!--Testimonial Section start-->
<div class="hero-client-section pad-bot-70 section-padding"  style="background-image: url(images/bg/bg2.png)">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">People Talking About Us</h2>
            </div>
            <div class="col-md-12 mar-bot-70">
                <div class="testimonial-wrapper swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide single-testimonial-item">
                            <div class="testimonial-img text-center">
                                <img src="images/clients/client_1.jpg" alt="...">
                            </div>
                            <div class="testimonial-content text-center">
                                <ul class="product-rating">
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                </ul>
                                <h5>Frank Jane</h5>
                                <span>CEO, Bloomberg</span>
                                <p>Lorem ipsum dolor adipisicing elit.assumenda quis corrupti iusto at laborum hic qui, minus, quasi modi assumenda quis corrupti chika.</p>
                            </div>
                        </div>
                        <div class="swiper-slide single-testimonial-item">
                            <div class="testimonial-img text-center">
                                <img src="images/clients/client_3.jpg" alt="...">
                            </div>
                            <div class="testimonial-content text-center">
                                <ul class="product-rating">
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                </ul>
                                <h5>Amanda Gordon</h5>
                                <span>CMO, TechTelsa</span>
                                <p>Lorem ipsum dolor adipisicing elit.assumenda quis corrupti iusto at laborum hic qui, minus, quasi modi assumenda quis corrupti.</p>
                            </div>
                        </div>
                        <div class="swiper-slide single-testimonial-item">
                            <div class="testimonial-img text-center">
                                <img src="images/clients/client_2.jpg" alt="...">
                            </div>
                            <div class="testimonial-content text-center">
                                <ul class="product-rating">
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                </ul>
                                <h5>Lee Priest</h5>
                                <span>MD, Cornia Inc</span>
                                <p>Lorem ipsum dolor adipisicing elit.assumenda quis corrupti iusto at laborum hic qui, minus, quasi modi assumenda quis corrupti. Lorem ipsum dolor.</p>
                            </div>
                        </div>
                        <div class="swiper-slide single-testimonial-item">
                            <div class="testimonial-img text-center">
                                <img src="images/clients/client_4.jpg" alt="...">
                            </div>
                            <div class="testimonial-content text-center">
                                <ul class="product-rating">
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                    <li><i class="ion-android-star-half"></i></li>
                                </ul>
                                <h5>Mark Henry</h5>
                                <span>CEO, Alpha Inc</span>
                                <p>Lorem ipsum dolor adipisicing elit.assumenda quis corrupti iusto at laborum hic qui, minus, quasi modi assumenda quis corrupti. Lorem ipsum.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="client-pagination"></div>
            </div>
        </div>
    </div>
</div>
<!--Testimonial Section ends-->
<!--Blog Posts starts
<div class="blog-posts v2 mar-bot-40 pad-top-60 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="section-title v1">Popular Posts</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="single-blog-item v2">
                    <img alt="..." src="images/blog/news_1.jpg">
                    <a href="#" class="blog-cat btn v6 red">Hotel</a>
                    <div class="blog-hover-content">
                        <h3 class="blog-title"><a href="single-news-one.html">Top 10 Homestay in London That you don't miss out</a></h3>
                        <a href="single-news-one.html" class="btn v6">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-blog-item v2">
                            <img src="images/blog/news_21.jpg" alt="...">
                            <a href="#" class="blog-cat btn v6 red">Events</a>
                            <div class="blog-hover-content">
                                <h3 class="blog-title"><a href="single-news-two.html">Top 20 greatest Street arts Of London.</a></h3>
                                <a href="single-news-one.html" class="btn v6">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-blog-item v2">
                            <img alt="..." src="images/blog/news_5.jpg">
                            <a href="#" class="blog-cat btn v6 red">Restaurant</a>
                            <div class="blog-hover-content">
                                <h3 class="blog-title"><a href="single-news-one.html">Story Behind favoula Restaurant.</a></h3>
                                <a href="single-news-one.html" class="btn v6">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-blog-item v2">
                            <img alt="..." src="images/blog/news_6.jpg">
                            <a href="#" class="blog-cat btn v6 red">Tour</a>
                            <div class="blog-hover-content">
                                <h3 class="blog-title"><a href="single-news-one.html">What to do in London.</a></h3>
                                <a href="single-news-one.html" class="btn v6">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!--Blog Posts ends-->
<!-- Scroll to top starts-->


<span class="scrolltotop"><i class="ion-arrow-up-c"></i></span>
<!-- Scroll to top ends-->

@endsection
