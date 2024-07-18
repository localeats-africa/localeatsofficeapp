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
use App\Models\TempOrder;
use App\Models\Area;
use App\Models\Role;
use App\Models\Level;
use App\Models\MergeInvoice;
use App\Models\Commission;
use App\Mail\NewUserEmail;
use App\Imports\OrderList;
use App\Imports\FoodMenuImportClass;
use App\Imports\OrdersImportClass;
use App\Models\Invoice;
use App\Models\Payout;

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;


class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'user-access:2', 'verified']);
    }

    public function index(Request $request){
        if ((Auth::user()->password_change_at == null)) {
            return redirect(route('show-change-password'));
         }
      else{
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $sumAllOrders = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->sum('order_amount');

        $countAllOrder = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count();


        $getOrderItem = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('description')->pluck('description');

        $string =  $getOrderItem;
        $substring = 'plate';
        $countAllPlate = substr_count($string, $substring);


        $countPlatformWhereOrderCame = DB::table('orders')
        ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')->distinct()
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count('platforms.id');

        $payouts = Orders::all()
        ->sum('payout');

        $commission = (int)$sumAllOrders - (int)$payouts ;
        //Commission::all()->sum('localeats_comm');


        $countPlatforms = Platforms::all();
        // a platform is ative is it has one or more active vendor
        $activePlatform = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
       ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')->distinct()
        ->where('sales_platform.vendor_status', 'active')
        ->get('sales_platform.platform_name');
        
        $countVendor = Vendor::all();
         // a vendor is consider active if it's active on one or more platform
         $countActiveVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
         ->where('sales_platform.vendor_status', 'active')
         ->get('sales_platform.vendor_id');
       
         $chowdeckVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.platform_name', 'chowdeck')
         ->get('sales_platform.vendor_id');
     
         $activeChowdeckVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.vendor_status', 'active')
         ->where('sales_platform.platform_name', 'chowdeck')
         ->get('sales_platform.vendor_id');
 
         $activeGlovoVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.vendor_status', 'active')
         ->where('sales_platform.platform_name', 'glovo')
         ->get('sales_platform.vendor_id');
 
         $glovoVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.platform_name', 'glovo')
         ->get('sales_platform.vendor_id');
 
         $activeEdenlifeVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.vendor_status', 'active')
         ->where('sales_platform.platform_name', 'edenlife')
         ->get('sales_platform.vendor_id');
 
         $edenlifeVendor = DB::table('sales_platform')
         ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
         ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
         ->where('sales_platform.platform_name', 'edenlife')
         ->get('sales_platform.vendor_id');

        return view('admin.admin', compact('name', 'role', 'countVendor',
         'countActiveVendor', 'countPlatforms', 'activePlatform',
         'activeChowdeckVendor', 'chowdeckVendor',
         'glovoVendor', 'activeGlovoVendor',   'activeEdenlifeVendor', 
         'edenlifeVendor',  'countPlatforms',  'payouts',
         'commission',   'sumAllOrders', 'countAllOrder', 'countPlatformWhereOrderCame',
         'countAllPlate'));
      }
    }

    public function newPlatform(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        return view('admin.new-platform', compact('role', 'name'));
    }

    public function addPlatform(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $this->validate($request, [ 
            'name'      => 'required|string|max:255',
            'logo'      => 'image|mimes:jpg,png,jpeg|max:300',
        ]);
        //this works on local host and linux
        //$path = $request->file('image')->store('/images/resource', ['disk' =>   'my_files']);  
           $logo= $request->file('logo');
           if(isset($logo)){
                $logoName =  rand(1000000000, 9999999999).'.jpeg';
                $logo->move(public_path('assets/images/platform'),$logoName);
                $logoPath = "/assets/images/platform/".$logoName; 
            }
           else {
            $logoPath = "";
            }
        $addPlatform = new Platforms();
        $addPlatform->name      = $request->name;
        $addPlatform->img_url   = $logoPath;
        $addPlatform->save();

        if($addPlatform){
            return redirect('all-platform')->with('add-platform', $request->name.' successfully added.');
        }
    }
   
    public function allPlatform(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $countPlatforms = Platforms::all();
        // a platform is ative is it has one or more active vendor
        $activePlatform = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
       ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')->distinct()
        ->where('sales_platform.vendor_status', 'active')
        ->get('sales_platform.platform_name');

        $activeChowdeckVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sales_platform.platform_name', 'chowdeck')
        ->get('sales_platform.vendor_id');
     
        $chowdeckVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.platform_name', 'chowdeck')
        ->get('sales_platform.vendor_id');

        $activeGlovoVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sales_platform.platform_name', 'glovo')
        ->get('sales_platform.vendor_id');

        $glovoVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.platform_name', 'glovo')
        ->get('sales_platform.vendor_id');

        $activeEdenlifeVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sales_platform.platform_name', 'edenlife')
        ->get('sales_platform.vendor_id');

        $edenlifeVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.platform_name', 'edenlife')
        ->get('sales_platform.vendor_id');

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $platform = 
        
        DB::table('platforms')
        ->where('platforms.deleted_at', null)
        ->select(['platforms.*' ])
        ->orderBy('platforms.created_at', 'desc')

        ->where(function ($query) use ($search) {  // <<<
        $query->where('platforms.name', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'platforms')->appends(['per_page'   => $perPage]);
        $pagination = $platform->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.all-platform',  compact(
                'perPage', 'name', 'role', 'platform',
                'activeChowdeckVendor', 'chowdeckVendor',
                'glovoVendor', 'activeGlovoVendor',
                'activeEdenlifeVendor', 'edenlifeVendor', 
                'activePlatform', 'countPlatforms'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('platform-status', 'No record order found'); }

        return view('admin.all-platform', compact('perPage', 'name', 
        'role', 'platform',  'activeChowdeckVendor', 'chowdeckVendor',
        'glovoVendor', 'activeGlovoVendor',   'activeEdenlifeVendor', 
        'edenlifeVendor', 'activePlatform', 'countPlatforms'));
    }

    public function approveVendor(Request $request, $vendor_id){

        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $updateVendor=  Vendor::where('id', $vendor_id)->update([
            'vendor_status'     =>  'approved',
        ]);
         
        if($updateVendor){
          return  redirect('all-vendor')->with('update-vendor', 'Approved successfully');
        }
        else{
          return  redirect()->back('update-error', 'Opps! something happen');
        }
    }

    public function updateVendorPlatformRef(Request $request, $id)
    {
        $platformRef = SalesPlatform::where('id',$id)
        ->update([
            'platform_ref' => $request->platform_ref
        ]);


        if($platformRef){

            $data = [
                'success' => true,
                'message'=> 'Update successful'
              ] ;
              
              return response()->json($data);

            //return  redirect()->back('update-status', 'Update successful');
        }
        else{
            $data = [
                'success' => false,
                'message'=> 'Opps! something happen'
              ] ;
              
              return response()->json($data);
        }

    }


    
    public function restaurant(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');
        
        $restaurant=  DB::table('restaurant_type')
        ->where('restaurant_type.deleted_at', null)
        ->select(['restaurant_type.*' ])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('restaurant_type.restaurant_type', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'restaurant')->appends(['per_page'   => $perPage]);
        $pagination = $restaurant->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.restaurant-type',  compact(
                'perPage', 'name', 'role', 'restaurant'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('error', 'No record order found'); }


        return view('admin.restaurant-type', compact('perPage', 'role', 'name', 'restaurant'));
    }

    public function addRestaurant(Request $request){
        $this->validate($request, [ 
            'restaurant'   => 'required|string|max:255',
        ]);

        $addRestaurant = new RestaurantType;
        $addRestaurant->restaurant_type = $request->restaurant;
        $addRestaurant->save();
        
        if($addRestaurant){
           return redirect()->back()->with('add-restaurant', 'Restaurant Type Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function foodType(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');
        
        $foodType=  DB::table('food_type')
        ->where('food_type.deleted_at', null)
        ->select(['food_type.*' ])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('food_type.food_type', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage,  $pageName = 'foodtype')->appends(['per_page'   => $perPage]);
        $pagination = $foodType->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.food-type',  compact(
                'perPage', 'name', 'role', 'foodType'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('error', 'No record order found'); }


        return view('admin.food-type', compact('perPage', 'role', 'name', 'foodType'));
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

    public function newUser(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $userRole = Role::where('role_name', '!=', 'superadmin')
        ->where('role_name', '!=', 'admin')
        ->get();

        return view('admin.staff', compact('role', 
        'name',  'userRole'));
    }

    public function addUser(Request $request){
        $this->validate($request, [ 
            'email'  => 'required|email|max:255',
            'name'   => 'required|string|max:255',
            'role'   => 'required|string|max:255',
            // 'phone'  => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:13',        
        ]);

        $verified = Carbon::now();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $num = 8;
        for ($a = 0; $a < $num; $a++) {
          $index = rand(0, strlen($characters) - 1);
          $randomString .= $characters[$index];
        }
        $tempoaryPassword = str_shuffle($randomString);
        $password =  Hash::make($tempoaryPassword);
        $checkUser = User::where('email', $request->email)->exists();
        if($checkUser){
            return redirect()->back()->with('error', 'This user is existing'); 
        }

        $addUser = new User;
        $addUser->fullname           = $request->name;
        $addUser->email             = $request->email;
        $addUser->role_id           = $request->role;
        $addUser->email_verified_at = $verified;
        $addUser->password          = $password;
        $addUser->save();
        
        if($addUser){
            $data = array(
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $tempoaryPassword,        
                );
                //dd($data);
                Mail::to($request->email)
                ->cc('admin@localeats.africa')
                //->bcc('admin@localeats.africa')
                ->send(new NewUserEmail($data));

           return redirect()->back()->with('add-user', 'New users added!. Password has been sent to ' .$request->email.'. Check inbox/Junk or Spam box.');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function allUser(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $userRole = Role::all();
        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');    
        $user=  DB::table('users')
        ->join('role', 'role.id', '=', 'users.role_id')
        ->where('users.deleted_at', null)
        ->where('users.email_verified_at', '!=', null)
        ->where('users.role_id', '!=', '1')
        ->where('users.role_id', '!=', '2')//except self
        ->select(['users.*', 'role.role_name' ])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('users.fullname', 'LIKE', '%'.$search.'%')
        ->orWhere('users.email', 'LIKE', '%'.$search.'%')
        ->orWhere('role.role_name', 'LIKE', '%'.$search.'%')
        ->orderBy('users.created_at', 'desc');
        })
        ->paginate($perPage,  $pageName = 'user')->appends(['per_page'   => $perPage]);
        $pagination = $user->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.all-staff',  compact(
                'perPage', 'name', 'role', 
                'user', 'userRole'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('staff-status', 'No record order found'); }

        return view('admin.all-staff', compact('perPage', 'role', 
        'name', 'userRole',   'user'));
    }

   
    public function allOrders(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $sumAllOrders = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->sum('order_amount');

        $countAllOrder = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count();


        $getOrderItem = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('description')->pluck('description');

        $string =  $getOrderItem;
        $substring = 'plate';
        $countAllPlate = substr_count($string, $substring);


        $countPlatformWhereOrderCame = DB::table('orders')
        ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')->distinct()
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count('platforms.id');

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');  

        $orders = DB::table('orders')
        ->join('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->join('users', 'orders.added_by', '=', 'users.id')
        ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->select(['orders.*', 'vendor.vendor_name', 'platforms.name', 'users.fullname'])
        ->orderBy('orders.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('orders.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.invoice_ref', 'LIKE', '%'.$search.'%')
               ->orderBy('orders.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'orders'
        )->appends(['per_page'   => $perPage]);
    
        $pagination = $orders->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.all-orders',  compact(
                'perPage', 'name', 'role', 'orders',
                'sumAllOrders', 'countAllOrder', 'countPlatformWhereOrderCame',
                'countAllPlate'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('order-status', 'No record order found');}
        return view('admin.all-orders', compact('name', 'role', 'orders', 
        'sumAllOrders', 'countAllOrder', 'countPlatformWhereOrderCame',
        'countAllPlate'));
    }


    public function deleteInvoice(Request $request, $id){
        $today = Carbon::now();
        $vendor_id = $request->vendor_id;

        $order = DB::table('orders')
        ->where('invoice_ref', '=', $id)
        ->where('vendor_id', '=', $vendor_id)
        ->update(array('deleted_at' => $today));

        if($order){
            $data = [
                'status' => true,
                'message'=> 'Record Deleted'
            ];
            return response()->json($data);
            //return redirect()->back()->with('invoice', 'Record Deleted');
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something went wrong'
            ];
            return response()->json($data);
           // return redirect()->back()->with('merge-error', 'Opps! something went wrong'); 
        }
    }
  
}//class