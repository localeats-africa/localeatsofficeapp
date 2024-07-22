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

    public function addVendorExpenses(Request $request){
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

        $expensesList = ExpensesList::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->get();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $expenses = VendorExpenses::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('description', 'LIKE', '%'.$search.'%')
        ->orWhere('cost', 'LIKE', '%'.$search.'%')
        ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage)->appends(['per_page'   => $perPage]);
        $pagination = $expenses->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('cashier.expenses',  compact('name', 'role', 
                'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('expenses-status', 'No record order found'); }

        return view('cashier.expenses',  compact('name', 'role', 
         'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses'));
    }

    public function addExpensesList(Request $request){
        $this->validate($request, [ 
            'vendor'  => 'required|max:255',
            'item'   => 'required|string|max:255'      
        ]);

        $storeExpense = new ExpensesList();
        $storeExpense->vendor_id    = $request->vendor;
        $storeExpense->item         = $request->item;
        $storeExpense->added_by     = Auth::user()->id;
        $storeExpense->save();

        if($storeExpense){
            $data = [
                'status' => true,
                'message'=> 'New list added successfully.'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
            return response()->json($data);
        }
    }

    public function storeVendorDailyExpenses(Request $request){
        $this->validate($request, [ 
            'vendor'        => 'required|max:255',
            'item'          => 'required|string|max:255',  
            'price'         => 'required|string|max:255'        
        ]);

        $expenses = new VendorExpenses();
        $expenses->vendor_id        = $request->vendor;
        $expenses->description      = $request->item;
        $expenses->cost             = $request->price;
        $expenses->added_by         = Auth::user()->id;
        $expenses->save();

        if($expenses){
            return redirect()->back()->with('expense-status', 'You have successfully added an Expenses');
        }
        else{
            return redirect()->back()->with('expense-error', 'Opps! something happend');
        
        }
    }

    public function offlineSales(Request $request){
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

        $salesList = OfflineFoodMenu::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('cashier.sales',  compact('name', 'role', 
        'vendorName','salesList', 'vendor_id'));
    }

    public function OfflineSaleList(Request $request){
        $this->validate($request, [ 
            'vendor'  => 'required|max:255',
            'item'   => 'required|string|max:255'      
        ]);

        $foodItem = new OfflineFoodMenu();
        $foodItem->vendor_id    = $request->vendor;
        $foodItem->item         = $request->item;
        $foodItem->added_by     = Auth::user()->id;
        $foodItem->save();

        if($foodItem){
            $data = [
                'status' => true,
                'message'=> 'New list added successfully.'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Something went wrong'
            ];
            return response()->json($data);
        }
    }

    public function storeVendorOfflineSale(Request $request){
        $this->validate($request, [ 
            'vendor'        => 'required|max:255',
            'item'          => 'required|string|max:255',  
            'price'         => 'required|string|max:255'        
        ]);

        $sales = new OfflineSales();
        $sales->vendor_id           = $request->vendor;
        $sales->sales_item          = $request->item;
        $sales->price               = $request->price;
        $sales->added_by            = Auth::user()->id;
        $sales->save();

        if($sales){
            return redirect()->back()->with('sales-status', 'You have successfully added a Sales');
        }
        else{
            return redirect()->back()->with('sales-error', 'Opps! something happend');
        
        }
    }
}//class
