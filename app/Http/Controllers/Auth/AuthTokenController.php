<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Models\ActiveCode;
use App\Notifications\LoginToWebsite as LoginToWebsiteNotification;

class AuthTokenController extends Controller
{
   public function getToken(Request $request)
   {
      if(! $request->session()->has('auth')) {
         return redirect(route('login'));
      }
      $request->session()->reflash();

      return view('auth.token');
   }

   public function postToken(Request $request)
   {

      $request->validate([
         'token' => 'required'
      ]);


      if(! $request->session()->has('auth')) {
         return redirect(route('login'));
      }

      $user = User::findOrFail($request->session()->get('auth.user_id'));

     $status = ActiveCode::verifyCode($request->token  , $user);


     if(! $status){
      alert()->error('کد صحیح نبود');

        return redirect(route('login'));
     }

     if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember'))) {
      $user->notify(new LoginToWebsiteNotification());  
      $user->activeCode()->delete();
        return redirect('/');
     }
     return redirect(route('login'));
   }
}
