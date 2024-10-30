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
use App\Models\VendorInventory;
use App\Models\TempVendorInventory;
use App\Models\InventoryItemSizes;
use App\Models\VendorInstoreSales;
use App\Models\FoodCategory;
use App\Models\VendorFoodMenu;
use App\Models\VendorExpensesCategory;
use App\Models\VendorOnlineSales;

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;


class StoreOwnersController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'user-access:11', 'verified']);
    }

    public function vendoraccount(Request $request){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $getVendorID = User::where('id', $user_id)->get('vendor')->toArray();
        $vendorID_list = array_column($getVendorID, 'vendor'); 
        $selectMultipleVendor= call_user_func_array('array_merge', $vendorID_list);
        $multipleVendor_list = Vendor::whereIn('id', $selectMultipleVendor)->get()->pluck('id');
        $removeBracket = substr($multipleVendor_list, 1, -1);
        $vendor_id =  str_replace('"', ' ', $removeBracket);
         //dd( $vendor_id );

        //payouts as online sales
        $payouts = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.vendor_id', $vendor_id)  
        ->sum('payout');
        // for localeats vendor
       $offlineSales = DB::table('offline_sales')
       ->where('vendor_id', $vendor_id)
       ->sum('price');

       $expenses = DB::table('vendor_expenses')
       ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_expenses.vendor_id')
       ->where('vendor_expenses.vendor_id', $vendor_id)
       ->sum('vendor_expenses.cost');

        return view('storeowner.storeowner-admin', compact('username', 'payouts'));

    }
}
