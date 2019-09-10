<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Auth;
class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login()
    {
        if (app('VoyagerAuth')->user()) {
            return redirect()->route('voyager.dashboard');
        }

        return Voyager::view('voyager::login');
    }

    public function postLogin(Request $request)
    {
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /*
     * Preempts $redirectTo member variable (from RedirectsUsers trait)
     */
    public function redirectTo()
    {
        $countries=Auth::user()->countries->pluck("id");
        $lat=0;
        $lon=0;
        foreach (Auth::user()->countries as $country) {
            $lat=$country->latitude;
            $lon=$country->longitude;
        }
        
          \Session::put('countries',$countries);
          config(["voyager.googlemaps.center.lat"=>$lat,"voyager.googlemaps.center.lng"=>$lon]);
          config()->set('voyager.googlemaps.center.lat', $lat); 
          config()->set('voyager.googlemaps.center.lng', $lon); 


          \Session::save();
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }
}
