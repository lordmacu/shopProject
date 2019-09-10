<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Region extends Model
{
    public function getAllByCountry(){
        
        $countries= \Session::get('countries');

        return $this
                ->select("regions.*")
                ->join("cities","cities.id","=","regions.city_id")
                ->join("countries","countries.id","=","cities.country_id")
                ->whereIn("countries.id",$countries)
                ->get();
    }
    
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    
    
}
