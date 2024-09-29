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
use App\Models\VendorInstoreSales;
use App\Models\FoodCategory;
use App\Models\VendorFoodMenu;
use App\Models\VendorExpensesCategory;

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
        $this->middleware(['auth', 'user-access:10', 'verified']);
    }
    public function outletAllSupplies(Request $request){
        $username = Auth::user()->username;
        $user_id = Auth::user()->id;

        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $subStoreID = DB::table('sub_store')
        ->where('user_id', $user_id)
        ->get('*')->pluck('id')->first();

        $parentName = DB::table('sub_store')
        ->join('multi_store', 'multi_store.id', 'sub_store.multi_store_id')
        ->where('sub_store.user_id', $user_id)
        ->get('multi_store.multi_store_name')->pluck('multi_store_name')->first();
        
        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $supply = DB::table('sub_vendor_inventory')->distinct()
        // ->join('vendor', 'vendor.id', 'sub_vendor_inventory.vendor_id')
         ->join('users', 'users.vendor', 'sub_vendor_inventory.vendor_id')
         //->join('sub_store', 'sub_store.user_id', 'users.id')
         ->whereNotNull('sub_vendor_inventory.number_of_items')
         ->select(['sub_vendor_inventory.*'])
         ->where('users.id', $user_id)
        ->where(function ($query) use ($search) {  // <<<
        $query->where('sub_vendor_inventory.supply_ref', 'LIKE', '%'.$search.'%')
                ->orWhere('sub_vendor_inventory.status', 'LIKE', '%'.$search.'%')
                ->orWhere('sub_vendor_inventory.created_at', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'supply')->appends(['per_page'   => $perPage]);
        $pagination = $supply->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return  view('multistore.child.all-supply', compact('perPage','role', 'subStoreID',
                'parentName', 'supply', 'username' ))->withDetails($pagination);     
            } 
        else{ 
            // Session::flash('food-status', 'No record order found'); 
            return  view('multistore.child.all-supply', compact('perPage', 'role', 'subStoreID',
            'parentName', 'supply', 'username' ))->with('food-status', 'No record order found'); 
        }
        return  view('multistore.child.all-supply', compact('perPage', 'role', 'subStoreID',
            'parentName', 'supply', 'username' ));
    }

    public function rejectSupply(Request $request){
        $id = $request->id;
        $remark = $request->remark;

        $update = DB::table('sub_vendor_inventory')
        ->where('id', $id)
        ->update([
            'remark' => $remark,
            'status' => 'rejected'
        ]);

       if($update){
        $data = [
            'status' => true,
            'message'=> 'Remark sent successfully.'
        ];
        return response()->json($data);
       }
       else{
        $data = [
            'status' => true,
            'message'=> 'Opps!  something went wrong.'
        ];
        return response()->json($data);
       }
     }

     public function acceptSupply(Request $request){
        $id = $request->id;

        $update = DB::table('sub_vendor_inventory')
        ->where('id', $id)
        ->update([
            'status' => 'accepted'
        ]);

       if($update){
        $data = [
            'status' => true,
            'message'=> 'Record save successfully.'
        ];
        return response()->json($data);
       }
       else{
        $data = [
            'status' => true,
            'message'=> 'Opps!  something went wrong.'
        ];
        return response()->json($data);
       }
     }
     
     public function inStoreSales(Request $request){
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

        $vendor_id = Vendor::join('users', 'users.vendor', 'vendor.id')
        ->where('users.id', $user_id)
        ->get('vendor.id')->pluck('id')->first();
        
        $storeName = Vendor::where('id', $vendor_id)
        ->get('*')->pluck('store_name')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $sales = VendorInstoreSales::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('food_item', 'LIKE', '%'.$search.'%')
        ->orWhere('category', 'LIKE', '%'.$search.'%')
        ->orWhere('date', 'LIKE', '%'.$search.'%')
        ->orWhere('price', 'LIKE', '%'.$search.'%')
        ->orWhere('added_by', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage)->appends(['per_page'   => $perPage]);
        $pagination = $sales->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.child.instore-sales',  compact('username', 'perPage', 
                'storeName','parentID', 'vendor_id',  'sales'))->withDetails( $pagination );     
            } 
        // else{return redirect()->back()->with('expenses-status', 'No record order found'); }
//dd($sales);
        return view('multistore.child.instore-sales',  compact('username', 'perPage', 
        'storeName','parentID', 'vendor_id',  'sales'));
    }

    
}
