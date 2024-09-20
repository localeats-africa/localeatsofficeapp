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
use App\Models\SubVendorInventory;


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

    public function allChildVendor(Request $request, $username){
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
//vendor_id is the child vendor
    public function outletSupplies(Request $request, $username, $vendor_id){
        if(Auth::user()){
            $username = Auth::user()->username;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $parentStoreID = DB::table('multi_store')
            ->where('user_id', $user_id)
            ->get('*')->pluck('id')->first();

            $outletStoreID = DB::table('sub_store')
            ->where('vendor_id', $vendor_id)
            ->get('*')->pluck('id')->first();

            $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
            ->select('*')->pluck('store_name')->first();

            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $supply = DB::table('sub_vendor_inventory')
            //->join('vendor_inventory', 'vendor_inventory.id', 'sub_vendor_inventory.inventory_id')
            ->join('sub_store', 'sub_store.vendor_id', '=','sub_vendor_inventory.vendor_id')
            ->where('sub_vendor_inventory.vendor_id', $vendor_id)
            ->where('sub_vendor_inventory.parent_id', $parentStoreID)
            ->select(['sub_vendor_inventory.*'])
            ->orderBy('sub_vendor_inventory.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('sub_vendor_inventory.supply', 'LIKE', '%'.$search.'%')
                    ->orWhere('sub_vendor_inventory.created_at', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'supply')->appends(['per_page'   => $perPage]);
            $pagination = $supply->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('multistore.parent.outlet-supply',  compact(
                    'perPage', 'username', 'role', 'parentStoreID', 
                    'outletStoreID', 'outletStoreName', 'supply','vendor_id'))->withDetails($pagination);     
                } 
            else{ 
                // Session::flash('food-status', 'No record order found'); 
                return view('multistore.parent.outlet-supply',  compact('perPage', 
                'username', 'role', 'parentStoreID', 'outletStoreID', 
                'outletStoreName', 'supply', 'vendor_id'))->with('food-status', 'No record order found'); 
            }
                return view('multistore.parent.outlet-supply',  compact('perPage', 
                'username', 'role', 'parentStoreID',  'outletStoreID', 
                'outletStoreName', 'supply', 'vendor_id'));
        } 
    }
//vendor_id is the child vendor
    public function supplyToOutlet(Request $request, $vendor_id){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentStoreID = DB::table('multi_store')
        ->where('user_id', $user_id)
        ->get('*')->pluck('id')->first();

        $outletStoreID = DB::table('sub_store')
        ->where('vendor_id', $vendor_id)
        ->get('*')->pluck('id')->first();

        $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
        ->select('*')->pluck('store_name')->first();
        
        $supply= VendorInventory::join('multi_store', 'multi_store.id',  'vendor_inventory.multi_store_id')
        ->where('multi_store.id',  $parentStoreID)
        ->get('vendor_inventory.*');

        return view('multistore.parent.send-supply', compact('role', 'username', 
        'parentStoreID', 'outletStoreID', 'outletStoreName', 'supply', 'vendor_id'));
    }
    
    //post //vendor_id is the child vendor
    public function sendSupplies(Request $request, $username, $vendor_id){
    }
  
  
}
