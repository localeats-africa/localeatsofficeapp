<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
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


    public function login(Request $request)
    {
        $input = $request->all();
     
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->role_id == '1') {
                return redirect()->route('superadmin');
            }else if (auth()->user()->role_id == '2') {
                return redirect()->route('admin');
            }else if (auth()->user()->role_id == '3') {
                return redirect()->route('manager');
            }else if (auth()->user()->role_id == '4') {
                return redirect()->route('finance');
            }else if (auth()->user()->role_id == '5') {
                return redirect()->route('auditor');
            }else if (auth()->user()->role_id == '6') {
                return redirect()->route('vendor_manager');
            }else if (auth()->user()->role_id == '7') {
                return redirect()->route('cashier');
            }else if (auth()->user()->role_id == '8') {
                return redirect()->route('account_manager');
            }else if (auth()->user()->role_id == '9') {
                $value = Auth::user()->username;
                return redirect()->route('/', [$value]);
            }else if (auth()->user()->role_id == '10') {
                $value = Auth::user()->username;
                return redirect()->route('/', [$value]);
            }
            else{
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Invalid Email or Password.');
        }
     
    }   

}