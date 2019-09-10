<div class="similar-listing">
    <div class="similar-listing-title">
        <h3>Similar Listings</h3>
    </div>
    <div class="swiper-container similar-list-wrap">
        <div class="swiper-wrapper">

             @foreach ($mightAlsoLike as $product)
               
               <div class="swiper-slide similar-item">
                <img src="{{ productImage($product->image) }}" class="img-fluid" alt="...">
                <div class="similar-title-box">
                    <h5><a href="{{ route('country.shop.show',[\Session::get('country')->slug,$product->slug] ) }}">{{ $product->name }}</a></h5>
                    <p><span class="price-amt">{{ $product->presentPrice() }}</span>/Avg</p>
                </div>
                <div class="customer-review">
                    <div class="rating-summary">
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
                    <p><i class="ion-ios-location"></i> {{ $product->name }}</p>
                </div>
            </div>
             
             
            @endforeach
        </div>
    </div>
    
    
    @if(count($mightAlsoLike)>1)
    <div class="slider-btn v3 similar-next"><i class="ion-arrow-right-c"></i></div>
    <div class="slider-btn v3 similar-prev"><i class="ion-arrow-left-c"></i></div>
    @endif
</div>

