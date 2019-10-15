<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductInventary extends Model
{
   
    public function checkInventary($id,$date){
        return $this
                ->where("price_product_id",$id)
                ->whereDate("date",$date)
                ->first();
    }
    
    
    public function checkInventaryByIdsAndDate($ids,$date){
        return $this
                ->select("date","product_inventaries.quantity","price_product_id")
                //->join("price_products","price_product_id","product_inventaries.id")
                ->whereIn("price_product_id",$ids)
                ->whereDate("date",$date)
                ->get();
    }
}
