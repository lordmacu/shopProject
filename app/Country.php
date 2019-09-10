<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function getContryByName($name){
        return $this->where("slug",$name)->first();
    }
  
    
    public function cities(){
        return $this->hasMany("App\City")->with("regions");
    }
}
