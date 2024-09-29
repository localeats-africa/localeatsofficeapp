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

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;


class MultiVendorController extends Controller
{
    //

    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function parent(Request $request, $username){
        if ((Auth::user()->password_change_at == null)) {
        $username = Auth::user()->username;
        return view('multistore.parent.admin', compact('username'));
    }
    else{
        return view('multistore.parent.admin');
        }
    }

    public function child(Request $request){
        if ((Auth::user()->password_change_at == null)) {
            return redirect(route('show-change-password'));
         }
       else{
        return view('multistore.child.admin');
       }
    }

    public function supplyReceipt(Request $request, $username, $supply_ref){
        $parentName =   DB::table('sub_vendor_inventory')
          ->join('multi_store', 'multi_store.id', 'sub_vendor_inventory.parent_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('multi_store.multi_store_name')->pluck('multi_store_name')->first();
  
          $parentLogo=  DB::table('sub_vendor_inventory')
          ->join('multi_store', 'multi_store.id', 'sub_vendor_inventory.parent_id')
          ->join('vendor', 'vendor.id', 'multi_store.vendor_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.vendor_logo')->pluck('vendor_logo')->first();

        $parentAddress=  DB::table('sub_vendor_inventory')
          ->join('multi_store', 'multi_store.id', 'sub_vendor_inventory.parent_id')
          ->join('vendor', 'vendor.id', 'multi_store.vendor_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.address')->pluck('address')->first();
  
          $parentEmail=  DB::table('sub_vendor_inventory')
          ->join('multi_store', 'multi_store.id', 'sub_vendor_inventory.parent_id')
          ->join('vendor', 'vendor.id', 'multi_store.vendor_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.email')->pluck('email')->first();
  
           $status = DB::table('sub_vendor_inventory')
            ->where('supply_ref', $supply_ref)
           ->where('number_of_items', '!=', null)
           ->pluck('status')->first();
  
           $storeName = DB::table('sub_vendor_inventory')
          ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
           ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.store_name')
          ->pluck('store_name')->first();
  
           $storeName =DB::table('sub_vendor_inventory')
           ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
           ->where('sub_vendor_inventory.supply_ref', $supply_ref)
           ->select('vendor.store_name')->pluck('store_name')->first();
  
          $storeAddress = DB::table('sub_vendor_inventory')
          ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.address')
          ->pluck('address')->first();
  
          $location = DB::table('sub_vendor_inventory')
          ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('vendor.store_area')
          ->pluck('store_area')->first();
  
          $vendorState = DB::table('sub_vendor_inventory')
          ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
          ->join('state', 'state.id', '=', 'vendor.state_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
          ->select('state.state')->pluck('state')->first();
          
          $vendorCountry = DB::table('sub_vendor_inventory')
          ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
          ->join('country', 'country.id', '=', 'vendor.country_id')
          ->where('sub_vendor_inventory.supply_ref', $supply_ref)
           ->select('country.country')->pluck('country')->first();
  
          $supply_date = DB::table('sub_vendor_inventory')
          ->where('supply_ref', $supply_ref)
          ->where('number_of_items', '!=', null)
          ->pluck('created_at')->first();
    
          $supply = DB::table('sub_vendor_inventory')
          ->where('supply_ref', $supply_ref)
          ->where('deleted_at', null)
          ->get(['sub_vendor_inventory.*']);
          return  view('multistore.supply-receipt', compact('supply_ref', 'status',
          'storeName', 'storeAddress', 'location', 'vendorState', 'vendorCountry',
          'supply_date', 'supply', 'parentName', 'parentAddress','parentEmail', 
          'username', 'parentLogo' ));
      }

    //Cashier
    public function addVendorExpenses(Request $request, $username){
        $username = Auth::user()->username;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        //a cashier should only see things for the vendor assigned to him
        $vendorName = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $id)
        ->get('vendor.store_name')->pluck('store_name')->first();

        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $id)
        ->get('vendor.id')->pluck('id')->first();

        $expensesList = ExpensesList::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->get();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $expenses = VendorExpenses::where('vendor_id', $vendor_id)
        ->orderBy('expense_date', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('description', 'LIKE', '%'.$search.'%')
        ->orWhere('cost', 'LIKE', '%'.$search.'%')
        ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage)->appends(['per_page'   => $perPage]);
        $pagination = $expenses->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.cashier.add-expenses',  compact('username', 'role', 
                'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('expenses-status', 'No record order found');
            return view('multistore.cashier.add-expenses',   compact('username', 'role', 
            'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses')); 
            }

        return view('multistore.cashier.add-expenses',   compact('username', 'role', 
         'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses'));
    }

    public function autocompleteExpenses(Request $request, $vendor_id)
    {
        $data = ExpensesList::where('vendor_id', $vendor_id)
        ->select("item as value", "id")
                    ->where('item', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
        return response()->json($data);     
    }

    public function storeVendorDailyExpenses(Request $request){
        $this->validate($request, [ 
            'item'          => 'required|string|max:255',  
            'price'         => 'required|string|max:255'     
        ]);
        $storeExpense = new ExpensesList();
        $storeExpense->vendor_id    = $request->vendor;
        $storeExpense->item         = $request->item;
        $storeExpense->added_by     = Auth::user()->id;
        $storeExpense->save();

        $expenses = new VendorExpenses();
        $expenses->vendor_id        = $request->vendor;
        $expenses->description      = $request->item;
        $expenses->cost             = $request->price;
        $expenses->added_by         = Auth::user()->id;
        $expenses->expense_date     = Carbon::now();
        $expenses->save();

        if($expenses){
            return redirect()->back()->with('expense-status', 'You have successfully added an Expenses');
        }
        else{
            return redirect()->back()->with('expense-error', 'Opps! something happend');
        
        }
    }

}
