<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;


class Region extends Model
{
            use Resizable;

    public function getAllByCountry(){
        
        $countries= \Session::get('countries');

        return $this
                ->select("regions.*")
                ->join("cities","cities.id","=","regions.city_id")
                ->join("countries","countries.id","=","cities.country_id")
                ->whereIn("countries.id",$countries)
                ->get();
    }
    
   
      public function cities(){
        return $this->hasMany("App\City")->with("products");
    }
    
     public function getAllRegionsByCountry(){
        $country=\Session::get('country');
        return $this
                ->where("country_id",$country->id)
                ->with("cities")
                ->get();
    }
}
