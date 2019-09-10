<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class City extends Model
{
        use Resizable;

     public function regions(){
        return $this->hasMany("App\Region")->with("products");
    }
    
    public function getAllCitiesByCountry(){
        $country=\Session::get('country');
        return $this
                ->where("country_id",$country->id)
                ->with("regions")
                ->get();
    }
    
    
}
