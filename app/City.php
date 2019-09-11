<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class City extends Model
{
        use Resizable;

   
    
     public function getAllByCountry(){
        
        $countries= \Session::get('countries');

        return $this
                ->select("cities.*")
                ->join("regions","regions.id","=","cities.region_id")
                ->join("countries","countries.id","=","regions.country_id")
                ->whereIn("countries.id",$countries)
                ->get();
    }
    
     public function products()
    {
        return $this->hasMany('App\Product');
    }
    
    
    public function getAllCitiesByCountry(){
        $country=\Session::get('country');
        return $this
                ->where("country_id",$country->id)
                ->with("regions")
                ->get();
    }
    
    
}
