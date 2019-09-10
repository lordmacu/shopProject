<?php

namespace App\Http\Middleware;

use Closure;
use App\Country;

class checkCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
     $countryName = $request->segment(1);
     
     $Country= new Country();
     $getContryByName= $Country->getContryByName($countryName);

     
     
     
      \Session::put('country',$getContryByName);
      \Session::save();
        return $next($request);
    }
}
