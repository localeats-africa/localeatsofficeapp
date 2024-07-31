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
use App\Models\ExpensesList;
use App\Models\OfflineSales;
use App\Models\VendorExpenses;
use App\Models\OfflineFoodMenu;

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

class CashierController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'user-access:7', 'verified']);
    }

    public function index(Request $request){
        if ((Auth::user()->password_change_at == null)) {
            return redirect(route('show-change-password'));
         }
       else{
        $name = Auth::user()->fullname;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        //a cashier should only see things for the vendor assigned to him
        $vendorName = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $id)
        ->get('vendor.vendor_name')->pluck('vendor_name')->first();

        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $id)
        ->get('vendor.id')->pluck('id')->first();

        $today = Carbon::now()->format('Y-m-d');

        $countDailyExpense = VendorExpenses::where('vendor_id', $vendor_id)
        ->where('vendor_expenses.created_at', $today)
        ->count();

        $countDailySales = OfflineSales::where('vendor_id', $vendor_id)
        ->whereDate('created_at', $today)
        ->count();

        $sumDailySales = OfflineSales::where('vendor_id', $vendor_id)
        ->whereDate('created_at', $today)
        ->sum('price');
        //dd($countDailySales);

        return view('cashier.cashier-dashboard',  compact('name', 'role', 
         'vendorName', 'countDailyExpense', 'countDailySales', 'sumDailySales'));
       }
    }

  
}//class
