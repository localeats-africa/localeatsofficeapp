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

       $profitLoss =  $payouts + $offlineSales =  $expenses ;

       $countAllOrder = Orders::where('deleted_at', null)
       ->where('orders.order_amount', '!=', null)
       ->where('orders.order_ref', '!=', null)
       ->where('vendor_id', $vendor_id)   
       ->count();

       $getOrderItem = DB::table('orders')
       ->where('deleted_at', null)
       ->where('orders.order_amount', '!=', null)
       ->where('orders.order_ref', '!=', null)
       ->where('vendor_id', $vendor_id)   
       ->get('description')->pluck('description');

       $string =  $getOrderItem;
       $substring = 'plate';
       $countAllPlate = substr_count($string, $substring);

        return view('storeowner.storeowner-admin', compact('username', 'payouts', 'offlineSales', 
        'expenses', 'countAllOrder', 'countAllPlate', 'profitLoss'));
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
                return view('storeowner.parent.food-category',  compact(
                'perPage', 'username', 'role', 'foodCategory', 'parentID'))->withDetails( $pagination );     
            } 
        else{
            //return redirect()->back()->with('error', 'No record order found')
            return view('storeowner.parent.food-category',  compact('perPage', 
            'username', 'role', 'foodCategory', 'parentID')); 
        }

        return view('storeowner.parent.food-category',  compact('perPage', 
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

    public function foodMenu(Request $request){
        if(Auth::user()){
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

            $perPage = $request->perPage ?? 15;
            $search = $request->input('search');
    
            $foodMenu = DB::table('offline_foodmenu')
            ->join('users', 'users.id', 'offline_foodmenu.added_by')
            ->where('offline_foodmenu.deleted_at', null)
            ->where('offline_foodmenu.vendor_id', $vendor_id)
            ->select(['offline_foodmenuoffline_foodmenu.*', 'users.fullname'])
            ->orderBy('offline_foodmenu.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('offline_foodmenu.soup', 'LIKE', '%'.$search.'%')
                ->orWhere('offline_foodmenu.swallow', 'LIKE', '%'.$search.'%')
                    ->orWhere('offline_foodmenu.protein', 'LIKE', '%'.$search.'%')
                    ->orWhere('offline_foodmenu.others', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'food')->appends(['per_page'   => $perPage]);
            $pagination = $foodMenu->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('storeowner.vendor-food-menu',  compact(
                    'perPage', 'username', 'role', 'foodMenu', 'vendor_idvendor_id'))->withDetails($pagination);     
                } 
            else{
                //return redirect()->back()->with('food-status', 'No record order found');
                return view('storeowner.vendor-food-menu',  compact(
                    'perPage', 'username', 'role', 'foodMenu', 'vendor_id'));
            }
            return view('storeowner.vendor-food-menu',  compact(
                'perPage', 'username', 'role', 'foodMenu', 'vendor_id'));
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

            $getVendorID = User::where('id', $user_id)->get('vendor')->toArray();
            $vendorID_list = array_column($getVendorID, 'vendor'); 
            $selectMultipleVendor= call_user_func_array('array_merge', $vendorID_list);
            $multipleVendor_list = Vendor::whereIn('id', $selectMultipleVendor)->get()->pluck('id');
            $removeBracket = substr($multipleVendor_list, 1, -1);
            $vendor_id =  str_replace('"', ' ', $removeBracket);

            $category = DB::table('offline_food_category')->get();

            return view('storeowner.add-food-menu',  compact('username', 
            'role', 'vendor_id', 'category'));
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

            $getVendorID = User::where('id', $user_id)->get('vendor')->toArray();
            $vendorID_list = array_column($getVendorID, 'vendor'); 
            $selectMultipleVendor= call_user_func_array('array_merge', $vendorID_list);
            $multipleVendor_list = Vendor::whereIn('id', $selectMultipleVendor)->get()->pluck('id');
            $removeBracket = substr($multipleVendor_list, 1, -1);
            $vendor_id =  str_replace('"', ' ', $removeBracket);

            $addMenu = new OfflineFoodMenu();
            $addMenu->added_by      = $user_id;
            $addMenu->food_item     = $request->item;
            $addMenu->price         = $request->price;
            $addMenu->category      = $request->category;
            $addMenu->store_id     = $vendor_id;
            $addMenu->save();
            if($addMenu){

                return redirect()->back()->with('add-menu', 'Menu  successfully added');
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

            $menu = OfflineFoodMenu::find($id);
            $vendor = Vendor::Join('food_menu', 'vendor.id', '=', 'offline_food_menu.vendor_id')
            ->where('offline_food_menu.id', $id)
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
            $menu = OfflineFoodMenu::find($id);
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
        $food = OfflineFoodMenu::find($id);
        $food->deleted_at  = $today ;
        $food->update();
        if($food){
            return redirect('all-food-menu')->with('food-status', 'Record Deleted Successfully');
        }  
    }
}
