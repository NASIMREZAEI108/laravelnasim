<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\ActiveCode;
use Illuminate\Http\Request;
use App\Rules\Recaptcha;
use App\Notifications\LoginToWebsiteNotification;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers , TwoFactorAuthenticate;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
  

        return $this->loggendin($request , $user);
    }
    


    /**
    * Validate the user login request.
    *
    * @param \Illuminate\Http\Request  $request
    * @return void
    *
    *@throws \Illuminate\Validation\ValidationException
    */
    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string' ,
            'g-recaptcha-response' => ['required' , new Recaptcha]
        ],[
            'g-recaptcha-response.required' => 'I am not a roobat'
        ]);
    }


}
       
         


