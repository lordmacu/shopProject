<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function getContryByName($name){
        return $this->where("slug",$name)->first();
    }
  
    
    public function regions(){
        return $this->hasMany("App\Region")->with("cities");
    }
}
