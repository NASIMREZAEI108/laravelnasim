<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback(Request $request)
    {
     
        try {
      $googleuser = Socialite::driver('google')->user();
      $user = User::where('email' , $googleUser->email)->first();
 
      if(! $user){
        
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(\Str::random(16)),
            ]);
    

           auth()->loginUsingId($user->id);
       }

        return $this->loggendin($request , $user) ?: redirect('/');
    
    } catch (\Exception $e) {
        //TODO show Error Message
       
   
        alert()->error('login with google was not success' , 'Message')->persistent('OK');

        return redirect('/login');
        }
    }
}
