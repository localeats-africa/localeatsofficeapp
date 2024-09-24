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
            ->whereNotNull('status')
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
                'status' => 'pending',
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

    public function supplyReceipt(Request $request, $username, $supply_ref){

      $parentName =   DB::table('sub_vendor_inventory')
        ->join('multi_store', 'multi_store.id', 'sub_vendor_inventory.parent_id')
        ->where('sub_vendor_inventory.supply_ref', $supply_ref)
        ->select('multi_store.multi_store_name')->pluck('multi_store_name')->first();

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
         ->where('status', '!=', null)
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
        ->where('status', '!=', null)
        ->pluck('created_at')->first();
  
        $supply = DB::table('sub_vendor_inventory')
        ->where('supply_ref', $supply_ref)
        ->where('deleted_at', null)
        ->get(['sub_vendor_inventory.*']);
        return  view('multistore.supply-receipt', compact('supply_ref', 'status',
        'storeName', 'storeAddress', 'location', 'vendorState', 'vendorCountry',
        'supply_date', 'supply', 'parentName', 'parentAddress','parentEmail' ));
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

  
}
