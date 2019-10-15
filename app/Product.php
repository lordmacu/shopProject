<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Traits\Resizable;

class Product extends Model
{
   // use SearchableTrait, Searchable;
    use Spatial;
    use Resizable;
    protected $spatial = ['location'];
    protected $fillable = ['quantity'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function city()
    {
        return $this->hasOne('App\City',"id","city_id");
    }
    
     public function category()
    {
        return $this->belongsTo('App\Category');
    }


public function amenities()
    {
        return $this->belongsToMany('App\Amenity');
    }    
    
    public function getFeaturedProducts($type){
        
         return $this->where('featured', true)
                ->take(8)
                ->whereIn("city_id", getRegionCountries())
                ->with("categories")
                 ->where("type_id",$type)
                ->inRandomOrder()
                ->get();
        
    }
    
    public function getCuoponProducts(){
        
         return $this
                ->whereIn("city_id", getRegionCountries())
                 ->has("coupon")
                ->with("coupon")
                ->inRandomOrder()
                ->get();
        
    }
    public function region()
    {
        return $this->hasOne('App\Region',"id","region_id");
    }
    
    public function pricesProduct()
    {
        return $this->hasMany('App\PriceProduct');
    }
    
    
     public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }
    
     public function organizator()
    {
        return $this->hasOne('App\Organizator',"id","organizator_id");
    }

    public function presentPrice()
    {
        return money_format('$%i', $this->price / 100);
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }
}
