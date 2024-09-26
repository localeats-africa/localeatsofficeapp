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
use App\Models\TempVendorInventory;
use App\Models\InventoryItemSizes;

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;


class VendorsController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function outletAllSupplies(){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;

        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $subStoreID = DB::table('sub_store')
        ->where('user_id', $user_id)
        ->get('*')->pluck('vendor_id')->first();

        $parentName = DB::table('sub_store')
        ->join('multi_store', 'multi_store.id', 'sub_store.multi_store_id')
        ->where('sub_store.user_id', $user_id)
        ->get('multi_store.store_name')->pluck('store_name')->first();
        
        $supply = DB::table('sub_vendor_inventory')
        ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
        ->where('supply_ref', $supply_ref)
        ->where('deleted_at', null)
        ->get(['sub_vendor_inventory.*']);
        return  view('multistore.supply-receipt', compact('supply_ref', 'status',
        'storeName', 'storeAddress', 'location', 'vendorState', 'vendorCountry',
        'supply_date', 'supply', 'parentName', 'parentAddress','parentEmail' ));
    

    }
}
