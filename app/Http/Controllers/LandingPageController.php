<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Region;
use App\City;
use App\Coupon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        
       $product=new Product();
       $getFeaturedProductsTours=$product->getFeaturedProducts(2);
       $getFeaturedProductsEvents=$product->getFeaturedProducts(1);
       
        $categories= new Category();
        $getAllFeaturedCategories=$categories->getAllFeaturedCategories();

        $region= new Region();
        $getAllRegionsByCountry=$region->getAllRegionsByCountry();

        $coupon= new Product();
         $getCuoponProducts=$coupon->getCuoponProducts();

         return view('landing-page')
                ->with('products', $getFeaturedProductsTours)
                ->with('events', $getFeaturedProductsEvents)
                ->with("regions",$getAllRegionsByCountry)
                ->with("coupons",$getCuoponProducts)
                ->with('categories', $getAllFeaturedCategories);
    }
}
