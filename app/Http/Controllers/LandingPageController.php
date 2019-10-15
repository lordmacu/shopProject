<?php

namespace App\Http\Controllers;

use App\Product;
use App\PriceProduct;
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
    
    
    public function processprices(){
        $products= Product::all();
        
        foreach ($products as $product) {
            dump($product->pricesProduct);
            
            
            /*if($product->prices){
                $pricesJson= json_decode($product->prices,true);
                foreach ($pricesJson as $priceJson) {
                    $PriceProduct= new PriceProduct();
                    $PriceProduct->name=$priceJson["name"];
                    $PriceProduct->quantity=$product->quantity;
                    $PriceProduct->value=$priceJson["value"];
                    $PriceProduct->product_id=$product->id;

                    $PriceProduct->save();
                }

            }else{
                $PriceProduct= new PriceProduct();
                
                $PriceProduct->product_id=$product->id;
                $PriceProduct->name="Normal";
                $PriceProduct->quantity=$product->quantity;
                $PriceProduct->value=$product->price;
                $PriceProduct->save();
            }
            */
            
            
        }
        return "a";
    }
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
