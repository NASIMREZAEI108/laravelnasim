<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    
    public function index() 
    {
           return view('profile.index');
    }

    public function manageTwoFactor() 
    {
        return view('profile.two-factor-auth');
    }

    public function postManageTwoFactor(Request $request)
    {
      
        // اعتبار سنجی
        $data = $request->validate([
            'type' =>'required|in:sms,off',
            'phone' => ['required_unless:type,off' , Rule::unique('users' , 'phone_number')->ignore($request->user()->id)]
        ]);

        if($data['type'] === 'sms') {
            if($request->user()->phone_number !== $data['phone']) {
        //    create a new code
        $code = ActiveCode::generateCode($request->user());
        $request->session()->flash('phone' , $data['phone']);
        //  send the code to user phone number
             
                // TODO Send Sms Notificaion
                $request->user()->notify(new ActiveCodeNotification($code , $data['phone']));

                


             return redirect(route('profile.2fa.phone'));

            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            } 
        }

        if($data['type'] === 'off') {
         $request->user()->update([
              'two_factor_type' => 'off'
         ]);
        }
        return back();
    }
   
    
        public function getPhoneVerify(Request $request)
        {
            if(! $request->session()->has('phone')) {
                return redirect(route('profile.2fa.manage'));
            }
            $request->session()->reflash();


            return view('profile.phone-verify');
        }
        

          public function postPhoneVerify(Request $request)
          {
              $request->validate([
                  'token' =>'required'
              ]);


              if(! $request->session()->has('phone')) {
                return redirect(route('profile.2fa.manage'));
            }

            
              $status = ActiveCode::verifyCode($request->token , $request->user());

            // dd($request->session()->get('phone'));

              if($status) {
                $request->user()->activeCode()->delete();
                $request->user()->update([
                    'phone_number' => $request->session()->get('phone'),
                    'two_factor_type' => 'sms'
                ]);
                alert()->success('عملیات موفق بود');
              }else {
                alert()->error('عملیات ناموفق بود');
              }

              return redirect(route('profile.2fa.manage'));
          }

        
        }
    



