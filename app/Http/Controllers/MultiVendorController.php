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
use App\Models\InventoryItemSizes;
use App\Models\VendorInstoreSales;
use App\Models\FoodCategory;
use App\Models\VendorFoodMenu;
use App\Models\VendorExpensesCategory;
use App\Models\TempInStoreSales;

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

        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $id)
        ->get('users.*')->pluck('parent_store')->first();

        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $id)
        ->get('vendor.id')->pluck('id')->first();

        $expensesCategory = VendorExpensesCategory::where('parent', $parentID)
        ->orderBy('created_at', 'desc')
        ->get();

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
                'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses','expensesCategory'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('expenses-status', 'No record order found');
            return view('multistore.cashier.add-expenses',   compact('username', 'role', 
            'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses','expensesCategory')); 
            }

        return view('multistore.cashier.add-expenses',   compact('username', 'role', 
         'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses', 'expensesCategory'));
    }

    public function autocompleteExpenses(Request $request, $vendor_id)
    {
        $data = ExpensesList::select("item as value", "id")
        ->where('item', 'LIKE', '%'. $request->get('search'). '%')
        ->where('vendor_id', $vendor_id)
        ->get();
        return response()->json($data);     
    }

    public function storeVendorDailyExpenses(Request $request){
        $this->validate($request, [ 
            'item'          => 'required|string|max:255',  
            'category'      => 'required|string|max:255',  
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
        $expenses->category         = $request->category;
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

    public function InStoreSales(Request $request){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        //a cashier should foodmenu from his HQ
        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $storeName = Vendor::join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->where('sub_store.user_id', $user_id)
        ->get('vendor.*')->pluck('store_name')->first();
  
        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $user_id)
        ->get('vendor.id')->pluck('id')->first();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $sales = VendorInstoreSales::where('vendor_id', $vendor_id)
        
        //->where('food_item', '!=', null)
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('food_item', 'LIKE', '%'.$search.'%')
                ->orWhere('category', 'LIKE', '%'.$search.'%')
                ->orWhere('price', 'LIKE', '%'.$search.'%')
                ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'food_item')->appends(['per_page'   => $perPage]);
        $pagination = $sales->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.cashier.instore-sales', compact('perPage', 'username',
                'storeName','parentID', 'vendor_id',  'sales'))->withDetails($pagination);     
            } 
        else{ 
            return view('multistore.cashier.sales', compact('perPage', 'username',
            'storeName','parentID', 'vendor_id',  'sales')); 
        }
        return view('multistore.cashier.sales', compact('perPage', 'username',
        'storeName','parentID', 'vendor_id',  'sales'));

    }
      //search foodmenu
   public function autocompleteFoodMenu(Request $request)
   {
       $data = VendorFoodMenu::select("food_item as value", "id")
       ->where('food_item', 'LIKE', '%'. $request->get('search'). '%')
       ->where('store_id',   $request->get('parent'))
        ->get();
       return response()->json($data);     
   }

    public function newInStoreSales(Request $request){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        //a cashier should foodmenu from his HQ
        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $storeName =  Vendor::join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->where('sub_store.user_id', $user_id)
        ->get('vendor.*')->pluck('store_name')->first();

        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $user_id)
        ->get('vendor.id')->pluck('id')->first();

        $foodMenu = VendorFoodMenu::where('store_id', $parentID)->get();

        $sales = TempInStoreSales::where('vendor_id', $vendor_id)
        ->where('food_item', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get('*');
        return view('multistore.cashier.add-new-sales',  compact('username',
        'storeName','parentID', 'vendor_id',  'foodMenu', 'sales'));

    }


   //save vendor InStore sales
   public function saveTempSales(Request $request){
    $username = Auth::user()->username;
    $user_id = Auth::user()->id;
    $role = DB::table('role')->select('role_name')
    ->join('users', 'users.role_id', 'role.id')
    ->where('users.id', $user_id)
    ->pluck('role_name')->first();

       $this->validate($request, [ 
           'quantity'      => 'required|max:255', 
           'item'          => 'required|max:255'         
       ]);

       $parentID = DB::table('multi_store')
       ->join('users', 'users.parent_store', 'multi_store.id')
       ->where('users.id',  $user_id)
       ->get('users.*')->pluck('parent_store')->first();

       $storeName =  Vendor::join('sub_store', 'sub_store.vendor_id', 'vendor.id')
       ->where('sub_store.user_id', $user_id)
       ->get('vendor.*')->pluck('store_name')->first();

       $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
       ->where('users.id', $user_id)
       ->get('vendor.id')->pluck('id')->first();

       $food            = $request->item;
       $quantity        =  $request->input('quantity');

       $foodCategory = VendorFoodMenu::where('food_item', $food)
       ->where('store_id',  $parentID)
       ->get()->pluck('category')->first();

       $foodPrice = VendorFoodMenu::where('food_item', $food)
       ->where('store_id',  $parentID)
       ->get()->pluck('price')->first();
       $amount = (int)$foodPrice  *  $quantity; 
       $today = Carbon::today();
   
       // SubVendorInventory
           $sales = new TempInStoreSales();
           $sales->added_by            = $user_id;
           $sales->parent              = $parentID;
           $sales->vendor_id           = $vendor_id;
           $sales->category            = $foodCategory;
           $sales->food_item           = $food; 
           $sales->price               = $foodPrice;
           $sales->quantity            = $quantity;
           $sales->amount              = $amount;
           $sales->date                = $today;
           $sales->save();

       if($sales){
           $response = [
               'code'      => '',
               'message'   => 'Sales saved successfully',
               'status'    => 'success',
           ];
           $data = json_encode($response, true);
            
           return redirect()->back()->with('sales-status', 'Item saved successfully');
       }
       else{
           return redirect()->back()->with('sales-error', 'Opps! something happend');
       }
   }

   public function deleteTempInStoreSales(Request $request, $id){
     // $id =  $request->id;
      $remove = TempInStoreSales::where('id', $id)->delete();
      if($remove){
       return redirect()->back()->with('sales-status', 'Item removed');  
      }
      else{
       return redirect()->back()->with('sales-error', 'Opps! something happend');
       }
   }

//post //vendor_id is the child vendor
   public function pushInstoreSales(Request $request){
        $user_id = Auth::user()->id;
       $username   = Auth::user()->username;
       $today = Carbon::today();
       $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $pin = mt_rand(1000000, 9999999);
       $supplyRef ='S'.str_shuffle($pin);

       $parentID = DB::table('multi_store')
       ->join('users', 'users.parent_store', 'multi_store.id')
       ->where('users.id',  $user_id)
       ->get('users.*')->pluck('parent_store')->first();

       $storeName =  Vendor::join('sub_store', 'sub_store.vendor_id', 'vendor.id')
       ->where('sub_store.user_id', $user_id)
       ->get('vendor.*')->pluck('store_name')->first();

       $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $user_id)
        ->get('vendor.id')->pluck('id')->first();

       $getSales = TempInStoreSales::where('parent', $parentID)
       ->where('vendor_id', $vendor_id )
       ->get();
      
       if($getSales->count() >= 1){
           foreach($getSales as $key  =>  $data){
                   $sales = new VendorInstoreSales();
                   $sales->added_by            = $data->added_by;
                   $sales->parent              = $data->parent;
                   $sales->vendor_id           = $data->vendor_id;
                    $sales->category           = $data->category;
                    $sales->food_item          = $data->food_item;
                    $sales->price              = $data->price;
                    $sales->quantity           = $data->quantity;
                    $sales->amount             = $data->amount;
                    $sales->date               = $data->date;
                   $sales->save();
           }
           if($sales){
               $response = [
                   'code'      => '',
                   'message'   => 'Sales sent successfully',
                   'status'    => 'success',
               ];
               $data = json_encode($response, true);

            //    $countRow =TempInStoreSales::where('parent', $parentID)
            //     ->where('vendor_id', $vendor_id )
            //    ->count();
             
            //    VendorInstoreSales::where('id', $sales->id)
            //    ->update([
            //    'number_of_items' => $countRow,
            //    ]);
              
                TempInStoreSales::where('parent', $parentID)
                ->where('vendor_id', $vendor_id )->delete();

               return redirect($username.'/instore-sales/' )->with('sales-status', 'Sales sent successfully');
           }
           else{
               return redirect()->back()->with('sales-error', 'Opps! something happend');
           } 
       }
       else{
           return redirect()->back()->with('sales-error', 'Opps! kindly enter supplies');    
       }     
   }

}
