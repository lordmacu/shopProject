<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Region;
use App\City;
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
       $getFeaturedProducts=$product->getFeaturedProducts();
        $categories= new Category();
        $getAllFeaturedCategories=$categories->getAllFeaturedCategories();

        $city= new City();
        $getAllCitiesByCountry=$city->getAllCitiesByCountry();

        
        return view('landing-page')
                ->with('products', $getFeaturedProducts)
                ->with("cities",$getAllCitiesByCountry)
                ->with('categories', $getAllFeaturedCategories);
    }
}
