@extends('base')

@section('title', $product->name)

@section('extra-css')

@endsection

@section('extra-js')

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_8C7p0Ws2gUu7wo0b6pK9Qu7LuzX2iWY&amp;libraries=places"></script>
<script>
    
    @if($product->getCoordinates())
var lat="{{$product->getCoordinates()[0]["lat"]}}";
var lng="{{$product->getCoordinates()[0]["lng"]}}";
    @endif
    
 $(function() {
      var $startDate = $('.start-date');
      var $endDate = $('.end-date');

console.log("esta es la fecha ",new  Date('{{$product->start_date}}'));
      $startDate.datepicker({
        autoHide: true,
        startDate: new  Date('{{$product->start_date}}'),

      });
      $endDate.datepicker({
        autoHide: true,
        startDate: $startDate.datepicker('getDate'),
      });

      $startDate.on('change', function () {
          console.log($startDate.datepicker('getDate'));
        $endDate.datepicker('setStartDate', $startDate.datepicker('getDate'));
      });
    });
  
    
    
    var marker="{{asset('images/others/marker.png')}}";
              new Swiper('.similar-list-wrap', {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            speed: 1000,
            navigation: {
                nextEl: '.similar-next',
                prevEl: '.similar-prev',
            },
            // Responsive breakpoints
            breakpoints: {

                767: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
            }
        });
             </script>
@endsection



@section('content')

 <div class="listing-details-wrapper bg-h" style="background-image: url({{ productImage($product->image) }}">
            <div class="overlay op-3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-details-title v1">
                            <div class="row">
                                <div class="col-lg-6 col-md-7 col-sm-12">
                                    <div class="single-listing-title float-left">
                                       @if($product->city) <p><a href="#" class="btn v6">{{$product->city->name}}</a></p>@endif
                                        
                                        
                                        <h2>{{$product->name}} <i class="icofont-tick-boxed"></i></h2>
                                        @if($product->address)<p><i class="ion-ios-location"></i> {{$product->address}}</p>
                                        @endif
                                       <!--- <div class="list-ratings">
                                            <span class="ion-android-star"></span>
                                            <span class="ion-android-star"></span>
                                            <span class="ion-android-star"></span>
                                            <span class="ion-android-star"></span>
                                            <span class="ion-android-star-half"></span>
                                            <a href="#">(31 Reviews)</a>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-5 col-sm-12">
                                    <div class="list-details-btn text-right sm-left">
                                      <!--  <div class="save-btn">
                                            <a href="#" class="btn v3 white"><i class="ion-heart"></i> Save</a>
                                        </div>-->
                                        <div class="share-btn">
                                            <a href="#" class="btn v3 white"><i class="ion-android-share-alt"></i> Share</a>
                                            <ul class="social-share">
                                                <li class="bg-fb"><a href="#"><i class="ion-social-facebook"></i></a></li>
                                                <li class="bg-tt"><a href="#"><i class="ion-social-twitter"></i></a></li>
                                                <li class="bg-ig"><a href="#"><i class="ion-social-instagram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Listing Details Hero ends-->
        <!--Listing Details Info starts-->
        <div class="list-details-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div id="list-menu" class="list_menu">
                            <ul class="list-details-tab fixed_nav">
                                <li class="nav-item active"><a href="#overview" class="active">Overview</a></li>
                                <li class="nav-item"><a href="#gallery">Gallery</a></li>
                                <!--<li class="nav-item"><a href="#rooms">Rooms</a></li>
                                <li class="nav-item"><a href="#reviews">Reviews</a></li>
                                <li class="nav-item"><a href="#add_review">Add Review</a></li>-->
                            </ul>
                        </div>
                        <!--Listing Details starts-->
                        <div class="list-details-wrap">
                            <div id="overview" class="list-details-section">
                                <h4>Overview</h4>
                                <div class="overview-content">
                                    <p class="mar-bot-10">{!!$product->description!!}</p>
                                </div> 
                                @if(count($product->amenities)>0)
                                <div class="mar-top-20">
                                    <h6>Comodidades</h6>
                                    <ul class="listing-features">
                                        @foreach($product->amenities as $amenity)
                                        <li><i class="{{$amenity->icon}}"></i> {{$amenity->name}}</li>
                                       @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div id="gallery" class="list-details-section">
                                <h4>Gallery</h4>
                                <!--Carousel Wrapper-->
                                <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails list-gallery" data-ride="carousel">
                                    <!--Slides-->
                                    <div class="carousel-inner" role="listbox">
                                        
                                          @if ($product->images)
                                                @foreach (json_decode($product->images, true) as $key=> $image)
                                                
                                                
                                                  <div class="carousel-item @if($key==0) active @endif">
                                                    <img class="d-block w-100" src="{{ productImage($image) }}" alt="slide">
                                                </div>
                                                @endforeach
                                          @endif
                                        
                                        
                                    </div>
                                    <!--Controls starts-->
                                    
                                    @if(count(json_decode($product->images, true))>1)
                                    <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
                                        <span class="ion-arrow-left-c" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
                                        <span class="ion-arrow-right-c" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                    @endif
                                    <!--Controls ends-->
                                   @if(count(json_decode($product->images, true))>1) <ol class="carousel-indicators  list-gallery-thumb">
                                        
                                         @if ($product->images)
                                                @foreach (json_decode($product->images, true) as $key=> $image)
                                                
                                                <li data-target="#carousel-thumb" data-slide-to="{{$key}}"><img class="img-fluid d-block w-100" src="{{productImage($image)}}" alt="..."></li>

                                                @endforeach
                                          @endif
                                        
                                    </ol>
                                   @endif
                                </div>
                                <!--/.Carousel Wrapper-->
                            </div>
                            
                            <!---
                            <div id="rooms" class="list-details-section mar-top-75">
                                <h4>Rooms</h4>
                                <div class="room-type-wrapper">
                                    <div class="room-type-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="images/category/hotel/single-room-1.jpg" data-lightbox="single-1">
                                                    <img src="images/category/hotel/single-room-1.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="feature-left float-left">
                                                            <h3>Standard Single Room</h3>
                                                            <p>Max : <span> 2 Persons</span>
                                                            </p>
                                                            <div class="facilities-list">
                                                                <ul>
                                                                    <li><i class="icofont-wifi"></i><span>Free WiFi</span></li>
                                                                    <li><i class="icofont-bathtub"></i><span>1 Bathroom</span></li>
                                                                    <li><i class="icofont-energy-air"></i><span>Air conditioner</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="feature-right float-right">
                                                            <span class="price-amt">$80</span>
                                                            Total for 1 room, 2 nights
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="room-type-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="images/category/hotel/single-room-2.jpg" data-lightbox="single-1">
                                                    <img src="images/category/hotel/single-room-2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="feature-left float-left">
                                                            <h3>Deluxe Room</h3>
                                                            <p>Max : <span> 3 Persons</span>
                                                            </p>
                                                            <div class="facilities-list">
                                                                <ul>
                                                                    <li><i class="icofont-wifi"></i><span>Free WiFi</span></li>
                                                                    <li><i class="icofont-bathtub"></i><span>1 Bathroom</span></li>
                                                                    <li><i class="icofont-energy-air"></i><span>Air conditioner</span></li>
                                                                    <li><i class="icofont-monitor"></i><span> Tv Inside</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="feature-right float-right">
                                                            <span class="price-amt">$150</span>
                                                            Total for 1 room, 2 nights
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="room-type-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="images/category/hotel/single-room-3.jpg" data-lightbox="single-1">
                                                    <img src="images/category/hotel/single-room-3.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="feature-left float-left">
                                                            <h3>Signature Room</h3>
                                                            <p>Max : <span> 4 Persons</span>
                                                            </p>
                                                            <div class="facilities-list">
                                                                <ul>
                                                                    <li><i class="icofont-wifi"></i><span>Free WiFi</span></li>
                                                                    <li><i class="icofont-bathtub"></i><span>1 Bathroom</span></li>
                                                                    <li><i class="icofont-energy-air"></i><span>Air conditioner</span></li>
                                                                    <li><i class="icofont-monitor"></i><span> Tv Inside</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="feature-right float-right">
                                                            <span class="price-amt">$110</span>
                                                            Total for 1 room, 2 nights
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                           <!-- <div id="reviews" class="list-details-section mar-top-10">
                                <h4>Reviews <span>(15)</span></h4>
                                <div class="review-box">
                                    <ul class="review_wrap">
                                        <li>
                                            <div class="customer-review_wrap">
                                                <div class="reviewer-img">
                                                    <img src="images/clients/reviewer-1.png" class="img-fluid" alt="...">
                                                    <p>Frank Jane</p>
                                                    <span>35 Reviews</span>
                                                </div>
                                                <div class="customer-content-wrap">
                                                    <div class="customer-content">
                                                        <div class="customer-review">
                                                            <h6>Best hotel in the Newyork city</h6>
                                                            <p>Posted 2 days ago</p>
                                                        </div>
                                                        <div class="customer-rating">5.0</div>
                                                    </div>
                                                    <p class="customer-text">I love the hotel here but it is so rare that I get to come here. Tasty Hand-Pulled hotel is the best type of whole in the wall restaurant. The staff are really nice, and you should be seated quickly.
                                                    </p>
                                                    <div class="review-img">
                                                        <img src="images/single-listing/gallery-1.jpg" alt="...">
                                                        <img src="images/single-listing/gallery-2.jpg" alt="...">
                                                        <img src="images/single-listing/gallery-3.jpg" alt="...">

                                                    </div>

                                                    <div class="like-btn mar-top-40">
                                                        <a href="#" class="rate-review float-left"><i class="icofont-thumbs-up"></i> Helpful Review <span>2</span></a>
                                                        <a href="#" class="rate-review float-right"><i class="icofont-reply"></i>Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="has-child">
                                                <li>
                                                    <div class="customer-review_wrap">
                                                        <div class="reviewer-img">
                                                            <img src="images/clients/reviewr-2.png" class="img-fluid" alt="#">
                                                            <p>Amanda G</p>
                                                            <span>35 Reviews</span>
                                                        </div>
                                                        <div class="customer-content-wrap">
                                                            <div class="customer-content">
                                                                <div class="customer-review">
                                                                    <h6>Best hotel in the Newyork city</h6>
                                                                    <p>Posted 1 day ago</p>
                                                                </div>
                                                            </div>
                                                            <p class="customer-text">I love the hotel here but it is so rare that I get to come here. Tasty Hand-Pulled hotel is the best type of whole in the wall restaurant. The staff are really nice, and you should be seated quickly.
                                                            </p>
                                                            <div class="like-btn mar-top-40">
                                                                <a href="#" class="rate-review float-left"><i class="icofont-thumbs-up"></i> Helpful Review <span>2</span></a>
                                                                <a href="#" class="rate-review float-right"><i class="icofont-reply"></i>Reply</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="customer-review_wrap">
                                                        <div class="reviewer-img">
                                                            <img src="images/clients/reviewer-1.png" class="img-fluid" alt="#">
                                                            <p>Frank Jane</p>
                                                            <span>35 Reviews</span>
                                                        </div>
                                                        <div class="customer-content-wrap">
                                                            <div class="customer-content">
                                                                <div class="customer-review">
                                                                    <h6>Best hotel in the Newyork city</h6>
                                                                    <p>Posted 10 hours ago</p>
                                                                </div>
                                                            </div>
                                                            <p class="customer-text">I love the hotel here but it is so rare that I get to come here. Tasty Hand-Pulled hotel is the best type of whole in the wall restaurant. The staff are really nice, and you should be seated quickly.
                                                            </p>
                                                            <div class="like-btn mar-top-40">
                                                                <a href="#" class="rate-review float-left"><i class="icofont-thumbs-up"></i> Helpful Review <span>2</span></a>
                                                                <a href="#" class="rate-review float-right"><i class="icofont-reply"></i>Reply</a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="customer-review_wrap">
                                                <div class="reviewer-img">
                                                    <img src="images/clients/reviewer-3.png" class="img-fluid" alt="#">
                                                    <p>Lee Priest</p>
                                                    <span>35 Reviews</span>
                                                </div>
                                                <div class="customer-content-wrap">
                                                    <div class="customer-content">
                                                        <div class="customer-review">
                                                            <h6>Best hotel in the Newyork city</h6>
                                                            <p>Posted 2 days ago</p>
                                                        </div>
                                                        <div class="customer-rating">5.0</div>
                                                    </div>
                                                    <p class="customer-text">I love the hotel here but it is so rare that I get to come here. Tasty Hand-Pulled hotel is the best type of whole in the wall restaurant. The staff are really nice, and you should be seated quickly.
                                                    </p>
                                                    <div class="like-btn mar-top-40">
                                                        <a href="#" class="rate-review float-left"><i class="icofont-thumbs-up"></i> Helpful Review <span>2</span></a>
                                                        <a href="#" class="rate-review float-right"><i class="icofont-reply"></i>Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="add_review" class="list-details-section mar-top-10">
                                <h4>Add Review</h4>
                                <form id="leave-review" class="contact-form" >
                                    <h4 class="contact-form__title">
                                        Rate us and Write a Review
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-7 col-12">
                                            <p class="contact-form__rate">
                                                Your rating for this listing:
                                            </p>
                                            <p class="contact-form__rate-bx">
                                                <i class="ion-ios-star"></i>
                                                <i class="ion-ios-star"></i>
                                                <i class="ion-ios-star"></i>
                                                <i class="ion-ios-star"></i>
                                                <i class="ion-ios-star"></i>
                                            </p>
                                            <p class="contact-form__rate-bx-show">
                                                <span class="rate-actual">0</span> / 5
                                            </p>
                                        </div>
                                        <div class="col-md-6 col-sm-5 col-12">
                                            <div class="contact-form__upload-btn xs-left">
                                                <input class="contact-form__input-file" type="file" name="photo-upload" id="photo-upload">
                                                <span>
                                                    <i class="icofont-upload-alt"></i>
                                                    Upload Photos
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="contact-form__input-text" type="text" name="name" id="name" placeholder="Name:">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="contact-form__input-text" type="text" name="mail" id="mail" placeholder="Email:">
                                        </div>
                                    </div>
                                    <textarea class="contact-form__textarea" name="comment" id="comment" placeholder="Comment"></textarea>
                                    <input class="btn v1" type="submit" name="submit-contact" id="submit_contact" value="Submit">
                                </form>
                            </div>
                            
                            -->
                        </div>
                        <!--Listing Details ends-->
                        <!--Similar Listing Starts-->
                        
                        
                            @include('partials.might-like')

                        <!--Similar Listing ends-->
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="listing-sidebar">
                            <div class="sidebar-widget info">
                                <h3><i class="ion-android-calendar"></i>Booking</h3>
                                <div class="row">
                                    
                                    <div class="col-md-12 mar-bot-15">
                                        <div id="datepicker-from-p" class="input-group date" data-start-date="29-09-2019" data-date-format="dd-mm-yyyy">
<input type="text" placeholder="Start date" aria-label="First name" class="form-control start-date">
                                            <span class="input-group-addon"><i class="icofont-ui-calendar"></i></span>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12 mar-bot-15">
                                        
                                        @if($product->prices)
                                        
                                            @if(count(json_decode($product->prices,true))>1)<div class="nice-select filter-input mar-top-0" tabindex="0"><span class="current">Select Room</span>
                                                <ul class="list">
                                                   @foreach(json_decode($product->prices,true) as $price)
                                                    <li class="option selected focus">{{$price["name"]}} ${{$price["value"]}}</li>
                                                   @endforeach 
                                                </ul>
                                            </div>
                                            @else
                                                {{json_decode($product->prices,true)[0]["name"]}} ${{json_decode($product->prices,true)[0]["value"]}}
                                            @endif
                                        @else
                                        Precio ${{$product->price}}
                                         @endif
                                    </div>
                                    <div class="col-md-6 mar-bot-15">
                                        <div class="book-amount">
                                            <label>Cantidad</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-left-minus btn">
                                                        <span class="ion-minus"></span>
                                                    </button>
                                                </span>
                                                <input type="text" class="form-control input-number" value="1">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-right-plus btn">
                                                        <span class="ion-plus"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="book-btn text-center">
                                    <a href="booking.html"> Request To Book</a>
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <div id="map"></div>
                               @if($product->address) <div class="address">
                                    <span class="ion-ios-location"></span>
                                    <p> {{$product->address}}</p>
                                </div>
                               @endif
                                <!--<div class="address">
                                    <span class="ion-ios-telephone"></span>
                                    <p> +44 20 7336 8898</p>
                                </div>
                                <div class="address">
                                    <span class="ion-android-globe"></span>
                                    <p>www.oceanparadise.com</p>
                                </div>-->
                            </div>
                             <!--
                            <div class="sidebar-widget">
                                <div class="business-time">
                                    <div class="business-title">
                                        <h6><i class="ion-android-alarm-clock"></i> Business Hours</h6>
                                        <span class="float-right">Open Now</span>
                                    </div>
                                    <ul class="business-hours">
                                        <li class="business-open">
                                            <span class="day">Saturday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">11:00 am</span> - <span class="time">06:00 pm</span>
                                            </div>
                                        </li>
                                        <li class="business-open trend-closed">
                                            <span class="day">Sunday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">Closed</span>
                                            </div>
                                        </li>
                                        <li class="business-open">
                                            <span class="day">Monday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">10:00 am</span> - <span class="time">06:00 pm</span>
                                            </div>
                                        </li>
                                        <li class="business-open">
                                            <span class="day">Tuesday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">10:00 am</span> - <span class="time">06:30 pm</span>
                                            </div>
                                        </li>
                                        <li class="business-open">
                                            <span class="day">Wednesday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">09:00 am</span> - <span class="time">05:00 pm</span>
                                            </div>
                                        </li>
                                        <li class="business-open">
                                            <span class="day">Thursday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">10:00 am</span> - <span class="time">07:00 pm</span>
                                            </div>
                                        </li>
                                        <li class="business-open">
                                            <span class="day">Friday</span>
                                            <div class="atbd_open_close_time">
                                                <span class="time">11:00 am</span> - <span class="time">06:00 pm</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                           <div class="sidebar-widget">
                                <div class="coupon-widget" style="background-image: url({{asset("images/category/coupon/coupon-bg-1.jpg")}});">
                                    <div class="overlay op-5"></div>
                                    <a href="#" class="coupon-top">
                                        <span class="coupon-link-icon"></span>
                                        <h3>Book Now &amp; get 20% discount</h3>
                                        <div class="daily-deals-wrap v1">
                                            <div class="countdown-deals text-center" data-countdown="2019/12/01"></div>
                                        </div>
                                    </a>
                                    <div class="coupon-bottom">
                                        <p>Coupon Code</p>
                                        <div class="coupon-code">DL76T</div>
                                    </div>
                                </div>
                            </div> 
                            <div class="sidebar-widget follow">
                                <div class="follow-img">
                                    <img src="{{asset("images/clients/reviewer-1.png")}}" class="img-fluid" alt="#">
                                    <h6>Christine Evans</h6>
                                    <span>New York</span>
                                </div>
                                <ul class="social-counts">
                                    <li>
                                        <h6>26</h6>
                                        <span>Listings</span>
                                    </li>
                                    <li>
                                        <h6>326</h6>
                                        <span>Followers</span>
                                    </li>
                                    <li>
                                        <h6>12</h6>
                                        <span>Following</span>
                                    </li>
                                </ul>
                                <div class="text-center mar-bot-25">
                                    <a href="#" class="btn v3"><i class="icofont-eye-alt"></i> Follow</a>
                                </div>
                            </div>
                            <div class="sidebar-widget ad-box">
                                <a href="#"><img src="{{asset("images/others/ad-1.jpg")}}" alt="..."></a>
                            </div>
                            <div class="sidebar-widget listing-tags">
                                <h4>Tags</h4>
                                <ul class="list-tags">
                                    <li><a href="#" class="btn v6 dark">Restaurant</a></li>
                                    <li><a href="#" class="btn v6 dark">Hotel</a></li>
                                    <li><a href="#" class="btn v6 dark">Travel</a></li>
                                    <li><a href="#" class="btn v6 dark">Food</a></li>
                                    <li><a href="#" class="btn v6 dark">Living</a></li>
                                    <li><a href="#" class="btn v6 dark">Luxury</a></li>
                                    <li><a href="#" class="btn v6 dark">Eat &amp; Drink</a></li>
                                </ul>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Listing Details Info ends-->
        <!-- Scroll to top starts-->
        <span class="scrolltotop"><i class="ion-arrow-up-c"></i></span>

@endsection
