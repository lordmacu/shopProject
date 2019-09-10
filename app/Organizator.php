<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Organizator extends Model
{
     public function getAllByCountry(){
        
        $countries= \Session::get('countries');

        return $this
        
                ->whereIn("country_id",$countries)
                ->get();
    }
}
