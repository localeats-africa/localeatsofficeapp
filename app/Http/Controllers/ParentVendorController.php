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
use App\Models\Platforms;
use App\Models\BankList;
use App\Models\FoodType;
use App\Models\FoodMenu;
use App\Models\RestaurantType;
use App\Models\Vendor;
use App\Models\Orders;
use App\Models\Area;
use App\Models\State;
use App\Models\Role;
use App\Models\Level;
use App\Models\Commission;
use App\Mail\NewUserEmail;
use App\Models\ExpensesList;
use App\Models\OfflineSales;
use App\Models\VendorExpenses;
use App\Models\OfflineFoodMenu;
use App\Models\MultiStoreRole;
use App\Models\MultiStore;
use App\Models\SubStore;
use App\Models\VendorInventory;


use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;


class ParentVendorController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'user-access:9', 'verified']);
    }

    public function allChildVendor(Request $request){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;

        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parent = DB::table('multi_store')
        ->where('user_id', $user_id)
        ->get('*')->pluck('id')->first();

        $countChildVendor =  DB::table('vendor')
        ->join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->where('sub_store.multi_store_id', $parent)
        ->get();
         // a vendor is consider active if it's active on one or more platform
        $countActiveChildVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sub_store.multi_store_id', $parent)
        ->get('sales_platform.vendor_id');
      
        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $childVendor = DB::table('vendor')
        ->join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->join('state', 'state.id', '=', 'vendor.state_id')
        ->where('sub_store.multi_store_id', $parent)
        ->select(['vendor.id', 'vendor.vendor_status', 'vendor.store_area',
        'vendor.store_name', 'state.state'])
        ->orderBy('sub_store.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor.store_name', 'LIKE', '%'.$search.'%')
                ->orWhere('vendor.vendor_status', 'LIKE', '%'.$search.'%')
                ->orWhere('vendor.store_area', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'outlets')->appends(['per_page'   => $perPage]);
        $pagination = $childVendor->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.parent.all-outlets',  compact(
                'perPage', 'role', 'countChildVendor', 'countActiveChildVendor', 
                'username', 'childVendor'))->withDetails($pagination);     
            } 
        else{ 
            // Session::flash('food-status', 'No record order found'); 
            return view('multistore.parent.all-outlets',  compact('perPage', 
            'role', 'countChildVendor', 'countActiveChildVendor', 
            'username', 'childVendor'))->with('food-status', 'No record order found'); 
            }
            return view('multistore.parent.all-outlets',  compact('perPage', 
            'role', 'countChildVendor', 'countActiveChildVendor', 'username', 'childVendor'));
    }

    public function outletSupplies(Request $request, $vendor_id){
        if(Auth::user()){
            $username = Auth::user()->username;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $outletID = DB::table('sub_store')
            ->where('vendor_id', $vendor_id)
            ->get('*')->pluck('id')->first();

            $storeName = DB::table('vendor')->where('id', $vendor_id)
            ->select('*')->pluck('store_name')->first();

            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $foodMenu = DB::table('vendor_inventory')
            ->join('vendor', 'vendor.id', 'food_menu.vendor_id')
            ->join('users', 'users.id', '=','food_menu.added_by')
            ->where('food_menu.deleted_at', null)
            ->where('food_menu.price', '!=', null)
            ->where('food_menu.item', '!=', null)
            ->where('food_menu.vendor_id', $vendor_id)
            ->select(['vendor.vendor_name', 'food_menu.*', 'users.fullname'])
            ->orderBy('food_menu.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('food_menu.item', 'LIKE', '%'.$search.'%')
                    ->orWhere('food_menu.price', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'food')->appends(['per_page'   => $perPage]);
            $pagination = $foodMenu->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('vendormanager.vendor-food-menu',  compact(
                    'perPage', 'name', 'role', 'foodMenu', 
                    'vendorName'))->withDetails($pagination);     
                } 
            else{ 
                // Session::flash('food-status', 'No record order found'); 
                return view('vendormanager.vendor-food-menu',  compact(
                'perPage', 'name', 'role', 'foodMenu', 
                'vendorName'))->with('food-status', 'No record order found'); }
            
            return view('vendormanager.vendor-food-menu', compact('perPage', 'role', 
            'name','foodMenu', 'vendorName'));


        }
    }
  
}
