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
use App\Models\FoodCategory;
use App\Models\VendorFoodMenu;
use App\Models\VendorExpensesCategory;
use App\Models\TempInStoreSales;
use App\Models\VendorOnlineSales;
use App\Models\VendorInstoreSales;


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

        $parent =  DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

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
            ->join('users', 'users.parent_store', 'multi_store.id')
            ->where('users.id',  $user_id)
            ->get('users.*')->pluck('parent_store')->first();

            $outletStoreID = DB::table('sub_store')
            ->where('vendor_id', $vendor_id)
            ->get('*')->pluck('id')->first();

            $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
            ->select('*')->pluck('store_name')->first();
         
            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $supply = DB::table('sub_vendor_inventory')->distinct()
            ->where('sub_vendor_inventory.vendor_id', $vendor_id)
            ->where('sub_vendor_inventory.parent_id', $parentStoreID)
            ->whereNotNull('number_of_items')
            ->orderBy('sub_vendor_inventory.created_at', 'desc')
           // ->groupby('sub_vendor_inventory.supply_ref')
            ->select(['sub_vendor_inventory.*'])
           
            ->where(function ($query) use ($search) {  // <<<
            $query->where('sub_vendor_inventory.supply_ref', 'LIKE', '%'.$search.'%')
                    ->orWhere('sub_vendor_inventory.status', 'LIKE', '%'.$search.'%')
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
    public function supplyToOutlet(Request $request,   $username, $vendor_id){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentStoreID =  DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $outletStoreID = DB::table('sub_store')
        ->where('vendor_id', $vendor_id)
        ->get('*')->pluck('id')->first();

        $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
        ->select('*')->pluck('store_name')->first();

        $sizes = InventoryItemSizes::all();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $supply = TempVendorInventory::where('parent_id',  $parentStoreID)
        ->select(['temp_vendor_inventory.*'])
        ->orderBy('temp_vendor_inventory.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('temp_vendor_inventory.supply', 'LIKE', '%'.$search.'%')
                ->orWhere('temp_vendor_inventory.created_at', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'supply')->appends(['per_page'   => $perPage]);
        $pagination = $supply->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.parent.send-supply', compact(
                'perPage', 'role', 'username', 'parentStoreID', 'outletStoreID', 
                'outletStoreName', 'supply', 'vendor_id', 'sizes'))->withDetails($pagination);     
            } 
        else{ 
            // Session::flash('food-status', 'No record order found'); 
            return view('multistore.parent.send-supply',  compact('perPage', 'role', 'username', 
        'parentStoreID', 'outletStoreID', 'outletStoreName', 'supply', 'vendor_id',
        'sizes'))->with('food-status', 'No record order found'); 
        }
        return view('multistore.parent.send-supply',  compact('perPage', 'role', 'username', 
        'parentStoreID', 'outletStoreID', 'outletStoreName', 'supply', 'vendor_id',
        'sizes'));
        
    }
//search supplies
    public function autocomplete(Request $request)
    {
        $data = VendorInventory::select("item as value", "id")
        ->where('item', 'LIKE', '%'. $request->get('search'). '%')
        ->where('multi_store_id',   $request->get('parent'))
        ->get();
        return response()->json($data);     
    }

    //save temporary child supply selected
    public function sendSupplies(Request $request){
        $this->validate($request, [ 
            'quantity'      => 'required|max:255', 
            'item'          => 'required|max:255'         
        ]);

        $username   = Auth::user()->username;
        $vendor_id  = $request->vendor_id;
        $parent_id  = $request->parent_id;
        $item       = $request->item;
        $qty        =  $request->input('quantity');
    
        // SubVendorInventory
            $supply = new TempVendorInventory();
            $supply->parent_id          = $request->parent_id;
            $supply->vendor_id          = $request->vendor_id;
            $supply->supply_qty         = $request->quantity;
            $supply->size               = $request->size;
            $supply->weight             = $request->weight;
            $supply->supply             = $request->item;
            $supply->save();
 
        if($supply){
            $response = [
                'code'      => '',
                'message'   => 'Supply sent successfully',
                'status'    => 'success',
            ];
            $data = json_encode($response, true);
             
            return redirect()->back()->with('supply-status', 'Item saved');
        }
        else{
            return redirect()->back()->with('sales-error', 'Opps! something happend');
        }
    }

    public function deleteTempSupply(Request $request, $id){
      // $id =  $request->id;
       $remove = TempVendorInventory::where('id', $id)->delete();
       if($remove){
        return redirect()->back()->with('supply-status', 'Item removed');  
       }
       else{
        return redirect()->back()->with('sales-error', 'Opps! something happend');
        }
    }

 //post //vendor_id is the child vendor
    public function pushSupplies(Request $request){
        $username   = Auth::user()->username;
        $today = Carbon::today();
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999);
        $supplyRef ='S'.str_shuffle($pin);

        $getSupply = TempVendorInventory::where('parent_id', $request->parent_id)
        ->get();
       
        if($getSupply->count() >= 1){
            foreach($getSupply as $key  =>  $data){
                    $supply = new SubVendorInventory();
                    $supply->parent_id          = $data->parent_id;
                    $supply->vendor_id          = $data->vendor_id;
                    $supply->supply_qty         = $data->supply_qty;
                    $supply->size               = $data->size;
                    $supply->weight             = $data->weight;
                    $supply->supply             = $data->supply;
                    $supply->supply_ref         = $supplyRef;
                    $supply->save();
            }
            if($supply){
                $response = [
                    'code'      => '',
                    'message'   => 'Supply sent successfully',
                    'status'    => 'success',
                ];
                $data = json_encode($response, true);

                $countRow =TempVendorInventory::where('parent_id', $request->parent_id)
                ->count();
              
                SubVendorInventory::where('id', $supply->id)
                ->update([
                'number_of_items' => $countRow,
                ]);
               
                TempVendorInventory::where('parent_id', $request->parent_id)->delete();

                return redirect($username.'/outlet-supplies/'.$request->vendor_id )->with('supply-status', 'Supply sent successfully');
            }
            else{
                return redirect()->back()->with('sales-error', 'Opps! something happend');
            } 
        }
        else{
            return redirect()->back()->with('supply-error', 'Opps! kindly enter supplies');    
        }     
    }

    public function updateSupplyQty(Request $request, $id){
        $user = SubVendorInventory::find($id);
        $user->supply_qty  = $request->quantity;
        $user->update();
     
        if($user){
            $data = [
                'success' => true,
                'message'=> 'Update successful' 
              ] ;
              
              //return response()->json($data);
            return  redirect()->back()->with('update-status', 'Update successful');
        }
        else{
            $data = [
                'success' => false,
                'message'=> 'Opps! something happen'
              ] ;
              
              return response()->json($data);
        }
    }

    //vendor_id is the child vendor
    public function editOutletSupply(Request $request, $username, $id){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentStoreID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $vendor_id = SubVendorInventory::where('id',  $id)
        ->get()->pluck('vendor_id')->first();

        $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
        ->select('*')->pluck('store_name')->first();
        $supply_ref =  SubVendorInventory::where('id',  $id)
        ->get()->pluck('supply_ref')->first();

        $sizes = InventoryItemSizes::all();
        $item = VendorInventory::all();
        $supply =  DB::table('sub_vendor_inventory')
        ->where('id', $id)
        ->get(['*']);

        return view('multistore.parent.edit-supply',  compact('role', 'username', 
        'parentStoreID', 'outletStoreName', 'supply', 'vendor_id',
        'sizes', 'supply_ref', 'item', 'id'));
        
    }

    public function updateSupply(Request $request, $id){

        $supply = SubVendorInventory::find($id);
        $supply->supply     =   $request->item;
        $supply->size       =   $request->size;
        $supply->weight     =   $request->weight;
        $supply->supply_qty =   $request->quantity;
        $supply->status      =   'pending';
        $supply->remark      =   null;
        $supply->save();
     
        if($supply){
            $data = [
                'success' => true,
                'message'=> 'Update successful' 
              ] ;
              
              //return response()->json($data);
            return  redirect()->back()->with('update-status', 'Update successful');
        }
        else{
            $data = [
                'success' => false,
                'message'=> 'Opps! something happen'
              ] ;
              
              return  redirect()->back()->with('update-status', 'Opps! something went wrong');
             // return response()->json($data);
        }
    }

     //view expeses list per outlet
     public function expensesList(Request $request,  $username, $vendor_id){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();
        //$vendor_id      =  $request->vendor_id;
        $startDate      =   date("Y-m-d", strtotime($request->from)) ;
        $endDate        =  date("Y-m-d", strtotime($request->to));
        
        $vendorName = Vendor::join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->join('multi_store', 'multi_store.id', 'sub_store.multi_store_id')
        ->where('multi_store.user_id',  $user_id)
        ->where('vendor.id', $vendor_id)
        ->get('vendor.*')->pluck('store_name')->first();
        //dd($vendorName);
        $vendor = Vendor::where('id', $vendor_id)->get();
      
        $vendorExpense = VendorExpenses::join('sub_store', 'sub_store.vendor_id', 'vendor_expenses.vendor_id')
        ->join('multi_store', 'multi_store.id', 'sub_store.multi_store_id')
        ->where('multi_store.user_id',  $user_id)
        ->where('vendor_expenses.vendor_id',  $vendor_id)
        ->whereDate('vendor_expenses.expense_date', '>=', $startDate)                                 
        ->whereDate('vendor_expenses.expense_date', '<=', $endDate) 
        ->get(['vendor_expenses.*']);

        $vendorTotalExpense = VendorExpenses::join('sub_store', 'sub_store.vendor_id', 'vendor_expenses.vendor_id')
        ->join('multi_store', 'multi_store.id', 'sub_store.multi_store_id')
        ->where('multi_store.user_id',  $user_id)
        ->where('vendor_expenses.vendor_id',  $vendor_id)
        ->whereDate('vendor_expenses.expense_date', '>=', $startDate)                                 
        ->whereDate('vendor_expenses.expense_date', '>=', $startDate)                                 
        ->whereDate('vendor_expenses.expense_date', '<=', $endDate) 
        ->sum('cost');

        return view('multistore.parent.outlet-expenses', compact('role', 'vendor',
        'vendorExpense', 'vendorTotalExpense', 'vendorName', 'startDate', 'endDate',
        'username', 'vendor_id'));
    }

    public function foodCategory(Request $request, $username){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');
        
        $foodCategory=  DB::table('food_category')
        ->where('deleted_at', null)
        ->where('store_id', $parentID)
        ->select(['*' ])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('food_category.category', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'foodCategory')->appends(['per_page'   => $perPage]);
        $pagination = $foodCategory->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.parent.food-category',  compact(
                'perPage', 'username', 'role', 'foodCategory', 'parentID'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('error', 'No record order found')
            return view('multistore.parent.food-category',  compact('perPage', 
            'username', 'role', 'foodCategory', 'parentID')); 
        }

        return view('multistore.parent.food-category',  compact('perPage', 
        'username', 'role', 'foodCategory', 'parentID'));
    }

    public function storeFoodCategory(Request $request){
        $this->validate($request, [ 
            'food_category'   => 'required|string|max:255',
        ]);

        $addFoodCategory = new FoodCategory;
        $addFoodCategory->category     = $request->food_category;
        $addFoodCategory->store_id     = $request->parent;
        $addFoodCategory->save();
        
        if($addFoodCategory){
           return redirect()->back()->with('add-food-type', 'Food Category Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function foodMenu(Request $request, $username){
        if(Auth::user()){
            $username = Auth::user()->username;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $parentID = DB::table('multi_store')
            ->join('users', 'users.parent_store', 'multi_store.id')
            ->where('users.id',  $user_id)
            ->get('users.*')->pluck('parent_store')->first();

            $perPage = $request->perPage ?? 15;
            $search = $request->input('search');
    
            $foodMenu = DB::table('vendor_food_menu')
            ->join('users', 'users.id', 'vendor_food_menu.added_by')
            ->where('vendor_food_menu.deleted_at', null)
            ->where('vendor_food_menu.store_id', $parentID)
            ->where('vendor_food_menu.price', '!=', null)
            ->where('vendor_food_menu.food_item', '!=', null)
            ->select(['vendor_food_menu.*', 'users.fullname'])
            ->orderBy('vendor_food_menu.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('vendor_food_menu.food_item', 'LIKE', '%'.$search.'%')
                ->orWhere('vendor_food_menu.category', 'LIKE', '%'.$search.'%')
                    ->orWhere('vendor_food_menu.price', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'food')->appends(['per_page'   => $perPage]);
            $pagination = $foodMenu->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('multistore.parent.vendor-food-menu',  compact(
                    'perPage', 'username', 'role', 'foodMenu', 'parentID'))->withDetails($pagination);     
                } 
            else{
                //return redirect()->back()->with('food-status', 'No record order found');
                return view('multistore.parent.vendor-food-menu',  compact(
                    'perPage', 'username', 'role', 'foodMenu', 'parentID'));
            }
            return view('multistore.parent.vendor-food-menu',  compact(
                'perPage', 'username', 'role', 'foodMenu', 'parentID'));
        }
    }

    public function newFoodMenu(Request $request){
        if(Auth::user()){
            $username = Auth::user()->username;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $parentID = DB::table('multi_store')
            ->join('users', 'users.parent_store', 'multi_store.id')
            ->where('users.id',  $user_id)
            ->get('users.*')->pluck('parent_store')->first();

            $category = FoodCategory::where('store_id', $parentID)->get();

            return view('multistore.parent.add-food-menu',  compact('username', 
            'role', 'parentID', 'category'));
        }
    }

    public function addFoodMenu(Request $request){
        $username = Auth::user()->username;
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();
            
            $this->validate($request, [ 
                'item'      => 'required|string|max:255',
                'price'     => 'required|string|max:255',
                'category'  => 'max:255',
            ]);

            $parentID = DB::table('multi_store')
            ->join('users', 'users.parent_store', 'multi_store.id')
            ->where('users.id',  $user_id)
            ->get('users.*')->pluck('parent_store')->first();

            $addMenu = new VendorFoodMenu();
            $addMenu->added_by      = $user_id;
            $addMenu->food_item     = $request->item;
            $addMenu->price         = $request->price;
            $addMenu->category      = $request->category;
            $addMenu->store_id     = $parentID;
            $addMenu->save();
            if($addMenu){

                return redirect($username. '/meal-menu')->with('add-menu', 'Menu  successfully added');
            }
            else{
                $error = [
                    'code'      => '',
                    'message'   => 'Something went wrong',
                    'status'    => 'error'
                ]; 
                $data = json_encode($error);
                return redirect()->back()->with('add-menu', 'Something went wrong');
            }

          
        }
    }

 

    public function importFoodMenu(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'vendor_name'=>'required|string|max:255',
        ]);
        // Get the uploaded file
        $file = $request->file('file');
        $vendor_id = $request->vendor_name;
     
        // Process the Excel file
      $import =  Excel::import(new FoodMenuImportClass($vendor_id), $file);

      if($import){
        return redirect()->back()->with('food-status', 'File imported successfully!');
      }
      else{
        return redirect()->back()->with('food-status', 'Opps!');
      }
 
    }

    public function editFoodMenu(Request $request, $id){
        if( Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $menu = FoodMenu::find($id);
            $vendor = Vendor::Join('food_menu', 'vendor.id', '=', 'food_menu.vendor_id')
            ->where('food_menu.id', $id)
            ->select('vendor.vendor_name')->pluck('vendor_name')->first();
            return view('vendormanager.edit-food-menu', compact('menu', 'role', 'vendor')); 
        }
          else { return Redirect::to('/login');
        }
  }

    public function updateFoodMenu(Request $request, $id)
    {
        $this->validate($request, [
            'item'  => 'max:255',
            'price'  => 'max:255',
            ]);
            $menu = FoodMenu::find($id);
            $menu->item         = $request->item;
            $menu->price        = $request->price;
            $menu->update();

            if($menu){
                return redirect()->back()->with('menu-status', 'Record Updated');
            }
            else{
                return redirect()->back()->with('menu-error', 'Opps! something went wrong'); 
            }

    }

    public function deleteFoodMenu(Request $request, $id){
        $today = Carbon::now();
        $food = FoodMenu::find($id);
        $food->deleted_at  = $today ;
        $food->update();
        if($food){
            return redirect('all-food-menu')->with('food-status', 'Record Deleted Successfully');
        }  
    }

    public function expensesCategory(Request $request, $username){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');
        
        $expensesCategory=  DB::table('vendor_expenses_category')
        ->where('deleted_at', null)
        ->where('parent', $parentID)
        ->select(['*' ])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor_expenses_category.category', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'expensesCategory')->appends(['per_page'   => $perPage]);
        $pagination = $expensesCategory->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.parent.expenses-category',  compact(
                'perPage', 'username', 'role', 'expensesCategory', 'parentID'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('error', 'No record order found')
            return view('multistore.parent.expenses-category',  compact(
                'perPage', 'username', 'role', 'expensesCategory', 'parentID')); 
        }

        return view('multistore.parent.expenses-category',  compact(
            'perPage', 'username', 'role', 'expensesCategory', 'parentID'));
    }

    public function storeExpensesCategory(Request $request){
        $this->validate($request, [ 
            'category'   => 'required|string|max:255',
        ]);

        $addExpensesCategory = new VendorExpensesCategory;
        $addExpensesCategory->category   = $request->category;
        $addExpensesCategory->parent     = $request->parent;
        $addExpensesCategory->save();
        
        if($addExpensesCategory){
           return redirect()->back()->with('add-food-type', 'Expenses Category Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function importOnlineSales(Request $request, $username){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $parentID = DB::table('multi_store')
        ->join('users', 'users.parent_store', 'multi_store.id')
        ->where('users.id',  $user_id)
        ->get('users.*')->pluck('parent_store')->first();

        $outlets =  DB::table('vendor')
        ->join('sub_store', 'sub_store.vendor_id', 'vendor.id')
        ->where('sub_store.multi_store_id', $parentID)
        ->get('vendor.*');

        $salesChannel =  DB::table('sales_platform')
        ->join('sub_store', 'sub_store.vendor_id', '=', 'sales_platform.vendor_id')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sub_store.multi_store_id', $parentID)
        ->distinct('platform_name')
        ->get('sales_platform.platform_name');
        //Platforms::all();

       // dd( $salesChannel );

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $onlineSales=  DB::table('vendor_online_sales')
        ->join('vendor', 'vendor.id', 'vendor_online_sales.vendor_id')
        ->join('platforms', 'platforms.name', 'vendor_online_sales.platform_id')
        ->where('parent_id', $parentID)
        ->select(['vendor.store_name', 'vendor_online_sales.*', 'platforms.name' ])
        ->orderBy('vendor_online_sales.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor_online_sales.description', 'LIKE', '%'.$search.'%')
        ->orwhere('vendor_online_sales.delivery_date', 'LIKE', '%'.$search.'%')
        ->orwhere('vendor.store_name', 'LIKE', '%'.$search.'%')
        ->orderBy('vendor_online_sales.delivery_date', 'desc');
        })
        ->paginate($perPage,  $pageName = 'onlineSales')->appends(['per_page'   => $perPage]);
        $pagination = $onlineSales->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.parent.import-online-sales',  compact(
                'perPage', 'username', 'role', 'outlets', 'parentID', 'salesChannel', 'onlineSales'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('error', 'No record order found')
            return view('multistore.parent.import-online-sales',  compact(
                'perPage', 'username', 'role', 'outlets', 'parentID', 'salesChannel', 'onlineSales')); 
        }
        
        return view('multistore.parent.import-online-sales',  compact(
            'perPage', 'username', 'role', 'outlets', 'parentID', 'salesChannel', 'onlineSales'));
    }

    public function outletDashboard(Request $request, $username, $vendor_id){
        $username = Auth::user()->username;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $weekStartMonday = Carbon::now()->startOfWeek();// Monday
            $weekEndSunday = Carbon::now()->endOfWeek(); //Snnday
            $startOfWeek = $weekStartMonday->format('Y-m-d');
            $endOfWeek =   $weekEndSunday->format('Y-m-d');
    
            $today = Carbon::now()->format('Y-m-d');
            $currentYear =  Carbon::now()->year;
    
            $sevenDaysBack = Carbon::now()->subDays(7)->startOfDay();
            $lastSevenDays  =  date('Y-m-d', strtotime($sevenDaysBack));
    
            $parent =  DB::table('multi_store')
            ->join('users', 'users.parent_store', 'multi_store.id')
            ->where('users.id',  $user_id)
            ->get('users.*')->pluck('parent_store')->first();
    
            $outletStoreName = DB::table('vendor')->where('id', $vendor_id)
            ->select('*')->pluck('store_name')->first();

            // count only active vendor
            $salesChannel = DB::table('sales_platform')
            ->join('sub_store', 'sub_store.vendor_id', '=', 'sales_platform.vendor_id')
            ->where('sales_platform.vendor_status', 'active')
            ->where('sub_store.vendor_id', $vendor_id)
            ->get('sales_platform.vendor_id');
           // dd($consumers);
    
           $offlineSales = DB::table('vendor_instore_sales')
           ->where('vendor_id', $vendor_id)
           ->where('parent', $parent)
           ->get();
    
           $countOutletsFromWhereOfflineSales = DB::table('vendor_instore_sales')
           ->where('vendor_id', $vendor_id)
           ->where('parent', $parent)
           ->count('vendor_id');
    
           $outletsExpenses = DB::table('vendor_expenses')
           ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_expenses.vendor_id')
           ->where('vendor_expenses.vendor_id', $vendor_id)
           ->where('parent', $parent)
           ->sum('vendor_expenses.cost');
    
            $countAllOrder = VendorOnlineSales::join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->count();
    
            $countPlatformWhereOrderCame = DB::table('vendor_online_sales')
            ->Join('platforms', 'vendor_online_sales.platform_id', '=', 'platforms.id')->distinct()
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->count('platforms.id');
    
            $sumAllOrders = DB::table('vendor_online_sales')   
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->sum('vendor_online_sales.order_amount'); 
    
            $chowdeckOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.id', '=', 'vendor_online_sales.platform_id')
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('platforms.name', 'chowdeck')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->get('vendor_online_sales.platform_id')->count();

            $sumChowdeckOrder= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('platforms.name', 'chowdeck')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->sum('vendor_online_sales.order_amount');
    
            $GlovoOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('platforms.name', 'glovo')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->distinct('vendor_online_sales.vendor_id')
            ->get('vendor_online_sales.vendor_id')->count();
    
            $sumGlovoOrder= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->join('sub_store', 'sub_store.vendor_id', '=', 'vendor_online_sales.vendor_id')
            ->where('sub_store.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->where('platforms.name', 'glovo')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->sum('vendor_online_sales.order_amount');
        //glovo
        $totalGlovoComm = (int)$sumGlovoOrder * 0.22;
        $glovoBTSCommission =  $sumGlovoOrder * 8 / 100;
        $glovoVAT =  $sumGlovoOrder * 7.5 / 100;
        $glovoComsuption = $sumGlovoOrder * 5 / 100;

        $allGlovoOrders = $sumGlovoOrder - $glovoBTSCommission  - $glovoVAT -  $glovoComsuption -  $totalGlovoComm;
        //chowdeck
        $chowdeckBTSCommission =  $sumChowdeckOrder * 8 / 100;
        $chowdeckVAT =  $sumChowdeckOrder * 7.5 / 100;
        $chowdeckComsuption = $sumChowdeckOrder * 5 / 100;
        $allChowdeckOrders = $sumChowdeckOrder - $chowdeckBTSCommission  - $chowdeckVAT -  $chowdeckComsuption;

      //  TOTAL DEDUCTION
         //bts percentage for 01Shawarma 8% of each order (online and offline)
        // vat is 7.5%$. comsuption tax 5 %
        $totalBTSCommission =  $sumAllOrders * 8 / 100;
        $totalVAT =  $sumAllOrders * 7.5 / 100;
        $totalComsuption = $sumAllOrders * 5 / 100;

        $vatConsumptionTax =  $totalVAT + $totalComsuption;
        $allSales = $sumAllOrders -  $vatConsumptionTax -  $totalBTSCommission -  $totalGlovoComm  ;
        $profiltLoss =  $allSales + $offlineSales->sum('amount') - $outletsExpenses  ;

        $platformOrders = DB::table('vendor_online_sales')
        ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')->distinct()
        ->where('platforms.deleted_at', null)
        ->where('vendor_online_sales.vendor_id', $vendor_id)
        ->where('vendor_online_sales.parent_id', $parent)
        ->get(['platforms.*']);

        $chartYearlyTotalSales = VendorOnlineSales::select(
            \DB::raw('YEAR(delivery_date) as year'),)
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_id', $vendor_id)
            ->where('parent_id', $parent)
            ->groupby('year')
            ->get();

        $chartMonthlyTotalSales = VendorOnlineSales::select(
            \DB::raw("COUNT(*) as total_sales"), 
            \DB::raw('DATE_FORMAT(delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(order_amount) as sales_volume'),
            )->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_id', $vendor_id)
            ->where('parent_id', $parent)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get(); 
    
            $chartSalesMonth = Arr::pluck($chartMonthlyTotalSales, 'month');
            $chartSalesVolume = Arr::pluck($chartMonthlyTotalSales, 'sales_volume');
            $chartSalesTotal = Arr::pluck($chartMonthlyTotalSales, 'total_sales');
    
            $monthlist = array_map(fn($chartSalesMonth) => Carbon::create(null, $chartSalesMonth)->format('M'), range(1, 12));
            $salesYear =  Arr::pluck($chartYearlyTotalSales, 'year');
            $data = [
             'month' => $chartSalesMonth,
             'sales' =>  $chartSalesVolume,
             'total' =>  $chartSalesTotal,
            ];
    
            $chowdeckOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->where('platforms.name', 'chowdeck')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->get('vendor_online_sales.platform_id')->count();
    
            $glovoOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->where('platforms.name', 'glovo')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->get('vendor_online_sales.platform_id')->count();
    
            $edenOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->where('platforms.name', 'edenlife')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->get('vendor_online_sales.platform_id')->count();
    
            $manoOrderCount= DB::table('vendor_online_sales')
            ->join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->where('platforms.name', 'mano')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->get('vendor_online_sales.platform_id')->count();
    
            // pie chart
            $chowdeckSalesPercentageChart = $chowdeckOrderCount / $countAllOrder * 100;
            $glovoSalesPercentageChart = $glovoOrderCount / $countAllOrder * 100;
            $edenSalesPercentageChart = $edenOrderCount / $countAllOrder * 100;
            $manoSalesPercentageChart = $manoOrderCount / $countAllOrder * 100;
    
            $piechartData = [            
            'label' => ['Chowdeck', 'Glovo', 'Eden', 'Mano'],
            'data' => [round($chowdeckSalesPercentageChart) , round($glovoSalesPercentageChart),  round($edenSalesPercentageChart), round( $manoSalesPercentageChart)] ,
            ];
            
        // barchart
        $chowdeckOrder =  VendorOnlineSales::join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(vendor_online_sales.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(vendor_online_sales.order_amount) as sales'),
            \DB::raw('COUNT(vendor_online_sales.order_amount) as count'),
            )
            ->where('platforms.name', 'chowdeck')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
           // ->whereYear('orders.delivery_date', '=', Carbon::now()->year)
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();

        $barChartChowdeckSales = Arr::pluck($chowdeckOrder, 'sales');
        $barChartChowdeckSCount = Arr::pluck($chowdeckOrder, 'count');
    
        $glovoOrder =  VendorOnlineSales::join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(vendor_online_sales.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(vendor_online_sales.order_amount) as sales'),
            \DB::raw('COUNT(vendor_online_sales.order_amount) as count'),
            )
            ->where('platforms.name', 'glovo')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            //->whereYear('orders.delivery_date', '=', Carbon::now()->year)
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
            $barChartGlovoSales = Arr::pluck($glovoOrder, 'sales');
    
        $edenOrder=  VendorOnlineSales::join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(vendor_online_sales.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(vendor_online_sales.order_amount) as sales'),
            \DB::raw('COUNT(vendor_online_sales.order_amount) as count'),
            )
            ->where('platforms.name', 'edenlife')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            //->whereYear('orders.delivery_date', '=', Carbon::now()->year)
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
            $barChartEdenSales = Arr::pluck($edenOrder, 'sales');
    
        $manoOrder =  VendorOnlineSales::join('platforms', 'platforms.name', '=', 'vendor_online_sales.platform_id')
            ->select(
            \DB::raw('DATE_FORMAT(vendor_online_sales.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(vendor_online_sales.order_amount) as sales'),
            \DB::raw('COUNT(vendor_online_sales.order_amount) as count'),
            )
            ->where('platforms.name', 'mano')
            ->where('vendor_online_sales.order_amount', '!=', null)
            ->where('vendor_online_sales.vendor_id', $vendor_id)
            ->where('vendor_online_sales.parent_id', $parent)
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
        $barChartManoSales = Arr::pluck($manoOrder, 'sales');

        //chowdeck
        $chowdeckResult = array_slice($barChartChowdeckSales, 1);
        $stringChowdeckSales =  implode(",",$chowdeckResult);
        $monthlyBTSCommissionChowdeck = (int) $stringChowdeckSales  * 8 / 100;
        $monthlyVATChowdeck =  (int) $stringChowdeckSales * 7.5 / 100;
        $monthlyComsuptionChowdeck = (int) $stringChowdeckSales * 5 / 100;
        $chowdeckBarChartTax = (int) $stringChowdeckSales - $monthlyBTSCommissionChowdeck - $monthlyVATChowdeck - $monthlyComsuptionChowdeck;
        $barChartChowdeck = [ '0' => 0, $chowdeckBarChartTax];
        // glovo
        $glovoResult = array_slice($barChartGlovoSales, 1);
        $stringGlovoSales =  implode(",",$glovoResult);
        $monthlyBTSCommissionGlovo = (int) $stringGlovoSales  * 8 / 100;
        $monthlyVATGlovo =  (int) $stringGlovoSales * 7.5 / 100;
        $monthlyComsuptionGlovo = (int) $stringGlovoSales * 5 / 100;
        $monthlyGlovoComm = (int)$stringGlovoSales * 0.22;
        $glovoBarChartTax = (int) $stringGlovoSales - $monthlyBTSCommissionGlovo - $monthlyVATGlovo - $monthlyComsuptionGlovo  -  $monthlyGlovoComm;

        $barChartGlovo = [ '0' => 0, $glovoBarChartTax];
          //dd(  $glovoBarChartlessTax);
        $barChartData = [
            'months'        =>  $chartSalesMonth,
            'chocdekSales'  =>  $barChartChowdeck ,
            'glovoSales'    =>  $barChartGlovo,
            'edenSales'     =>  '',
            'manoSales'     => '',
        ]; 
            return view('multistore.parent.outlet-dashboard', compact('username','parent', 'vendor_id',
        'offlineSales', 'salesChannel', 'countAllOrder', 'countPlatformWhereOrderCame', 'sumAllOrders', 
         'chowdeckOrderCount', 'countOutletsFromWhereOfflineSales','outletsExpenses',
        'GlovoOrderCount', 'sumGlovoOrder',  'sumChowdeckOrder', 
        'totalBTSCommission', 'vatConsumptionTax', 'profiltLoss', 'salesYear', 'platformOrders',
        'chowdeckOrderCount','glovoOrderCount', 'edenOrderCount', 'currentYear',
        'chowdeckSalesPercentageChart', 'glovoSalesPercentageChart', 
        'edenSalesPercentageChart', 'piechartData' ,  'barChartData', 'manoOrderCount', 
        'manoSalesPercentageChart', 'data', 'allGlovoOrders', 'allChowdeckOrders', 'allSales', 'outletStoreName'));
           }
       

}
