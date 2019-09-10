<?php



Route::group(['prefix' => 'admin'], function () {

    Voyager::routes();
        Route::get('login', ['uses' => 'Auth\AuthController@login', 'as' => 'login']);
        Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'postlogin']);

     
        
        
});


Route::group(['prefix' => '{country}',"middleware"=>["country"],"as"=>"country."], function () {

    Route::get('/', 'LandingPageController@index')->name('landing-page');

    Route::get('/shop', 'ShopController@index')->name('shop.index');
    Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');

    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart/{product}', 'CartController@store')->name('cart.store');
    Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
    Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
    Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

    Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');
    Route::post('/saveForLater/switchToCart/{product}', 'SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');

    Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
    Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');

    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
    Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
    Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

    Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');


    Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');



    Route::get('/edit/', [ 'as' => 'users.edit', 'uses' => 'UserController@edit']);
    Route::post('logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/search', 'ShopController@search')->name('search');

    Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');

});

