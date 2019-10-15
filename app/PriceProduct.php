<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PriceProduct extends Model
{
    public function deleteAllById($id){
        return $this->where("product_id",$id)->delete();
    }
    
}
