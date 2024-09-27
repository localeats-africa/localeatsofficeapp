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

        $parentStoreID = DB::table('multi_store')
        ->where('user_id', $user_id)
        ->get('*')->pluck('id')->first();

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
        ->where('user_id', $user_id)
        ->get('*')->pluck('id')->first();

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
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $parentID = DB::table('multi_store')
        ->where('user_id',  $id)
        ->get()->pluck('id')->first();

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
                'perPage', 'username', 'role', 'foodCategory'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('error', 'No record order found')
            return view('multistore.parent.food-category',  compact('perPage', 
            'username', 'role', 'foodCategory')); 
        }

        return view('multistore.parent.food-category',  compact('perPage', 
        'username', 'role', 'foodCategory'));
    }

    public function addFoodType(Request $request){
        $this->validate($request, [ 
            'food_type'   => 'required|string|max:255',
        ]);

        $addFoodType = new FoodType;
        $addFoodType->food_type = $request->food_type;
        $addFoodType->save();
        
        if($addFoodType){
           return redirect()->back()->with('add-food-type', 'Food Type Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

  
}
