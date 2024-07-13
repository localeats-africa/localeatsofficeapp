<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller
{
    //
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }
          
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleTwitterCallback()
    {
        try {
        
            $user = Socialite::driver('twitter')->user();
         
            $finduser = User::where('twitter_id', $user->id)->first();

            $getUserRole = User::where('email', $user->email)
            ->get('*')->pluck('role_id')->first();
         
            if($finduser){
         
                Auth::login($finduser);
        
               // return redirect()->intended('dashboard');
          
                if($user->email && $getUserRole =='1'){
                    return redirect()->intended('superadmin');
                }
                elseif($user->email && $getUserRole =='2'){
                    return redirect()->intended('admin');
                }else if ($user->email && $getUserRole == '3') {
                    return redirect()->intended('manager');
                }else if ($user->email && $getUserRole == '4') {
                    return redirect()->intended('finance');
                }else if ($user->email && $getUserRole == '5') {
                    return redirect()->intended('auditor');
                }else if ($user->email && $getUserRole == '6') {
                    return redirect()->intended('vendor_manager');
                }else{
                    return redirect()->intended('/')->with('error', 'No twitter email found');
                }
         
            }else{
                // $newUser = User::updateOrCreate(['email' => $user->email],[
                //         'name' => $user->name,
                //         'twitter_id'=> $user->id,
                //         'password' => encrypt('123456dummy')
                //     ]);
        
                // Auth::login($newUser);
        
                // return redirect()->intended('dashboard');
                $updateUserTwitterID = User::where('email', $user->email)
                ->update([
                    'twitter_id'=> $user->id,
                ]);
         
                 if($user->email && $getUserRole =='1'){
                     return redirect()->intended('superadmin');
                 }
                 elseif($user->email && $getUserRole =='2'){
                     return redirect()->intended('admin');
                 }else if ($user->email && $getUserRole == '3') {
                     return redirect()->intended('manager');
                 }else if ($user->email && $getUserRole == '4') {
                     return redirect()->intended('finance');
                 }else if ($user->email && $getUserRole == '5') {
                     return redirect()->intended('auditor');
                 }else if ($user->email && $getUserRole == '6') {
                     return redirect()->intended('vendor_manager');
                 }else{
                     return redirect()->intended('/')->with('error', 'No twitter email found');
                 }
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
