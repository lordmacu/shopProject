<?php

use Carbon\Carbon;

function presentPrice($price)
{
    return money_format('$%i', $price / 100);
}

function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}

function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}

function productImage($path)
{
    return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
}

function countryRoute($route,$parameters=0){
    
    
    if($parameters!=0){
            return route('country.'.$route,[\Session::get('country')->slug,$parameters]);

    }else{
            return route('country.'.$route,\Session::get('country')->slug);

    }
}

function countProductRegins($regions){
    $produts=0;
    foreach ($regions as $value) {
        $produts+=$value->products->count();
    }
    
    return $produts;
    
    
    
}

function getRegionCountries(){
    
    $country=\Session::get('country');
    $regions=[];
    foreach($country->cities as $city){
        foreach ($city->regions as $region){
            $regions[]=$region->id;
        }
    }
    return $regions;
}

function getNumbers()
{
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['name'] ?? null;
    $newSubtotal = (Cart::subtotal() - $discount);
    if ($newSubtotal < 0) {
        $newSubtotal = 0;
    }
    $newTax = $newSubtotal * $tax;
    $newTotal = $newSubtotal * (1 + $tax);

    return collect([
        'tax' => $tax,
        'discount' => $discount,
        'code' => $code,
        'newSubtotal' => $newSubtotal,
        'newTax' => $newTax,
        'newTotal' => $newTotal,
    ]);
}

function getStockLevel($quantity)
{
    if ($quantity > setting('site.stock_threshold', 5)) {
        $stockLevel = '<div class="badge badge-success">In Stock</div>';
    } elseif ($quantity <= setting('site.stock_threshold', 5) && $quantity > 0) {
        $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
    } else {
        $stockLevel = '<div class="badge badge-danger">Not available</div>';
    }

    return $stockLevel;
}
