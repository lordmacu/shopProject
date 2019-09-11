<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class Coupon extends Model
{
    
    use Resizable;

    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->type == 'fixed') {
            return $this->value;
        } elseif ($this->type == 'percent') {
            return round(($this->percent_off / 100) * $total);
        } else {
            return 0;
        }
    }
    
     public function getAllCouponsByCountry(){
        $country=\Session::get('country');
        return $this
                ->where("country_id",$country->id)
                ->get();
    }
}
