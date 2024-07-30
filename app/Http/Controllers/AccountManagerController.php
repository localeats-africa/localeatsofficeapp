<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\SalesPlatform;
use App\Models\BankList;
use App\Models\FoodType;
use App\Models\FoodMenu;
use App\Models\RestaurantType;
use App\Models\Vendor;
use App\Models\Area;
use Excel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;
use Validator;
use Session;
use Paystack;
use Storage;
use Mail;
use Notification;
use DateTime;

class AccountManagerController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'user-access:8', 'verified']);
    }

    public function index(Request $request){
        if ((Auth::user()->password_change_at == null)) {
            return redirect(route('show-change-password'));
         }
       else{
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $countVendor = Vendor::all();
        $countActivevendor = Vendor::where('vendor_status', 'active');
       
        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $vendor = DB::table('vendor')
        ->join('restaurant_type', 'restaurant_type.id', '=','vendor.restaurant_type')
        ->join('state', 'state.id', '=', 'vendor.state_id')
        ->join('country', 'country.id', '=', 'vendor.country_id')
        ->select(['vendor.vendor_ref', 'vendor.vendor_name', 
        'vendor.contact_phone', 'vendor.contact_fname', 
        'vendor.contact_lname', 'vendor.vendor_status', 
        'vendor.email', 'vendor.address',  'vendor.bank_name',
        'vendor.account_number', 'vendor.account_name', 
        'vendor.delivery_time',  'vendor.id',
        'restaurant_type.restaurant_type', 'vendor.food_type'])
        ->orderBy('vendor.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor.vendor_ref', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.contact_phone', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.email', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.vendor_status', 'LIKE', '%'.$search.'%');
        })->paginate($perPage,  $pageName = 'vendor')->appends(['per_page'   => $perPage]);
        $pagination = $vendor->appends ( array ('search' => $search) );
        if (count ( $pagination ) > 0){
            return view('accountmanager.account-manager',  compact(
            'perPage', 'name', 'role', 'vendor', 'countVendor',
            'countActivevendor'))->withDetails( $pagination );     
        } 
        else{return redirect()->back()->with('vendor-status', 'No record order found'); }

        return view('accountmanager.account-manager',  compact('perPage' , 'name', 'role', 
        'vendor', 'countVendor', 'countActivevendor'));
       }
    }

    public function allVendors(Request $request){
     
        $name = Auth::user()->name;
        $id = Auth::user()->id; 
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');
        $vendor = DB::table('vendor')
        ->join('restaurant_type', 'restaurant_type.id', 'vendor.restaurant_type')
        ->join('food_type', 'food_type.id', 'vendor.food_type')
        ->join('state', 'state.id', 'vendor.state_id')
        ->join('country', 'country.id', 'vendor.country_id')
        ->select(['vendor.*', 
        'restaurant_type.restaurant_type', 
        'food_type.food_type', 
        'state.state', 
        'country.country'])
        ->orderBy('vendor.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor.vendor_ref', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.food_type', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.contact_phone', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.email', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.state', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.country', 'LIKE', '%'.$search.'%')
        ->orWhere('vendor.status', 'LIKE', '%'.$search.'%')
        ->orderBy('vendor.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'vendor'
        )->appends(['per_page'   => $perPage]);
    
        $pagination = $vendor->appends ( array ('search' => $search) );
        if (count ( $pagination ) > 0){
            return view('vendormanager.manager',  compact(
            'perPage', 'name', 'role', 'vendor'))->withDetails( $pagination );     
        } 
        else{return redirect()->back()->with('vendor-status', 'No record order found'); }
        return view('vendormanager.manager',  compact('perPage' , 'name', 'role', 
        'vendor'));
}

}//class
