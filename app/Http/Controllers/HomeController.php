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
use App\Imports\OrderList;
use App\Imports\OrdersImportClass;
use App\Imports\FoodMenuImportClass;
use App\Exports\ExportOrderList;
use App\Models\Invoice;
use App\Models\Payout;
use App\Mail\NewUserEmail;
use App\Mail\EmailVendorInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ExpensesList;
use App\Models\OfflineSales;
use App\Models\VendorExpenses;
use App\Models\OfflineFoodMenu;

use Excel;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        return view('home', compact('role', 'name'));
    }
    public function showChangePassword(Request $request){
        if(Auth::user()){
            $name = Auth::user()->name;
            $id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
        
            return view('auth.passwords.change-password', compact('role', 'name'));
        }
    }

    public function changePassword(Request $request){
        if(Auth::user()){
           
            $validatedData = $request->validate([
                'password'              => 'required|min:8|confirmed',
                'password_confirmation'  => 'required|min:8',
            ]);
            //Change Password   bcrypt();
            $user = Auth::user();
            $user->password = Hash::make($request->get('password'));
            $user->password_change_at = Carbon::now();// set to empty.
            $user->save();
            if($user){
                $vendormanager = DB::table('users')
                ->select('role_id')
                ->where('role_id', '6')
                ->pluck('role_id')->first();

                $admin = DB::table('users')
                ->select('role_id')
                ->where('role_id', '2')
                ->pluck('role_id')->first();
               
                if(Auth::user()->role_id == $vendormanager){
                    return redirect('vendormanager')->with('new-password', 'Your password was change successfully' );
                }

                if(Auth::user()->role_id == $admin){
                    return redirect('admin')->with('new-password', 'Your password was change successfully ');
                }
            
            }
     
        }
        
    }

    public function newVendor(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $stateID = DB::table('state')->select('*')
        ->where('state', 'lagos')
        ->pluck('id')->first();

        $state = DB::table('state')->select('*')
        ->where('state', 'lagos')
        ->pluck('state')->first();

        $countryID = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('id')->first();

        $country = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('country')->first();

        $selectBankName = BankList::all();
        $selectFoodType = FoodType::all();
        $selectRestaurantType = RestaurantType::all();

        return view('vendormanager.add-new-vendor', compact('name', 
        'role', 'state', 'country', 'selectBankName',
        'selectFoodType', 'selectRestaurantType', 'stateID', 'countryID'));
    }

    public function addVendor(Request $request){
        if(Auth::user()){
         
            $name = Auth::user()->name;
            $id = Auth::user()->id;
            // generate a pin based on 2 * 5 digits + a random character
            $pin = mt_rand(100000, 999999);
            // shuffle pin
            $vendorRef = 'V'.str_shuffle($pin); 
            // dd( $vendor_ref);

            $this->validate($request, [ 
                'store_name'               => 'required|string|max:255',
                'area'                      => 'required|string|max:255',
                'restaurant_type'           => 'required|string|max:255',
                'food_type'                 => 'required|max:255',
                'number_of_store_location'  => 'required|string|max:255',
                'delivery_time'             => 'required|string|max:255',
                'first_name'                => 'required|string|max:255',
                'last_name'                 => 'required|string|max:255',
                'phone'                     => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:13',
                'email'                     => 'max:255', 
                'address'                   => 'required|string|max:255', 
                'bankName'                  => 'string|max:255', 
                'accountNumber'             => 'max:255', 
            ]);
            //$foodType = json_encode($request->food_type);
            $foodType = $request->food_type;
            $vendorStatus = 'pending';

            $vendorName = $request->area. '-' .$foodType;
       
            $addVendor = new Vendor();
            $addVendor->vendor_ref                  = $vendorRef;
            $addVendor->added_by                    = $id;
            $addVendor->store_name                 = $request->store_name;
            $addVendor->store_area                 = $request->area;
            $addVendor->vendor_name                 = $vendorName;
            $addVendor->restaurant_type             = $request->restaurant_type;
            $addVendor->food_type                   = $foodType;
            $addVendor->number_of_store_locations   = $request->number_of_store_location;
            $addVendor->delivery_time               = $request->delivery_time;
            $addVendor->description                 = $request->description;
            $addVendor->contact_fname               = $request->first_name;
            $addVendor->contact_lname               = $request->last_name;
            $addVendor->contact_phone               = $request->phone;
            $addVendor->email                       = $request->email;
            $addVendor->address                     = $request->address;
            $addVendor->state_id                    = $request->state;
            $addVendor->country_id                  = $request->country;
            $addVendor->bank_name                   = $request->bankName;
            $addVendor->account_number              = $request->accountNumber;
            $addVendor->account_name                = $request->accountName;
            $addVendor->vendor_status               = $vendorStatus;
            $addVendor->save();

            if($addVendor){
                //create vendor id in sales platform table
                $platformStatus ='inactive';
                $platforms = Platforms::all();
                
               foreach($platforms as $platform){
                    $addPlatform = new SalesPlatform();
                    $addPlatform->vendor_id         = $addVendor->id;
                    $addPlatform->platform_name     = $platform->name;
                    $addPlatform->vendor_status     = $platformStatus;
                    $addPlatform->save();
               }

                $response = [
                    'code'      => '',
                    'message'   => 'Vendor added successfully',
                    'status'    => 'success',
                ];
                $data = json_encode($response, true);

                $vendormanager = DB::table('users')
                ->select('role_id')
                ->where('role_id', '6')
                ->pluck('role_id')->first();

                $admin = DB::table('users')
                ->select('role_id')
                ->where('role_id', '2')
                ->pluck('role_id')->first();

                if(Auth::user()->role_id == $vendormanager){
                    return redirect('vendormanager')->with('add-vendor', 'Vendor  successfully added' );
                }

                if(Auth::user()->role_id == $admin){
                    return redirect('admin')->with('add-vendor', 'Vendor  successfully added');
                }
            
            }
            else{
                $error = [
                    'code'      => '',
                    'message'   => 'Something went wrong',
                    'status'    => 'error'
                ]; 
                $data = json_encode($error);
                return redirect()->back()->with('add-vendor', 'Something went wrong');
            }
      
        }
    }

    public function allVendor(Request $request){
        if(Auth::user()){
            $name = Auth::user()->name;
            $id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
    
            $countVendor = Vendor::all();
             // a vendor is consider active if it's active on one or more platform
            $countActivevendor = DB::table('sales_platform')
            ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
            ->where('sales_platform.vendor_status', 'active')
            ->get('sales_platform.vendor_id');
       
            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $vendor = DB::table('vendor')
            ->join('restaurant_type', 'restaurant_type.id', '=','vendor.restaurant_type')
            ->join('state', 'state.id', '=', 'vendor.state_id')
            ->join('country', 'country.id', '=', 'vendor.country_id')
            ->select(['vendor.vendor_ref', 'vendor.vendor_name', 
            'vendor.contact_phone', 'vendor.contact_fname', 
            'vendor.contact_lname', 'vendor.vendor_status', 
            'vendor.email', 'vendor.address',  'vendor.bank_name',
            'vendor.account_number', 'vendor.account_name', 
            'vendor.delivery_time',  'vendor.id',
            'restaurant_type.restaurant_type', 'vendor.food_type'])
            ->orderBy('vendor.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('vendor.vendor_ref', 'LIKE', '%'.$search.'%')
                ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
                ->orWhere('vendor.contact_phone', 'LIKE', '%'.$search.'%')
                    ->orWhere('vendor.email', 'LIKE', '%'.$search.'%')
                    ->orWhere('vendor.vendor_status', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'vendor')->appends(['per_page'   => $perPage]);
            $pagination = $vendor->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('vendormanager.all-vendor',  compact(
                    'perPage', 'name', 'role', 'vendor', 'countVendor',
                    'countActivevendor'))->withDetails( $pagination );     
                } 
            else{ return  redirect()->back()->with('vendor-status', 'No record order found'); }

            return view('vendormanager.all-vendor',  compact('perPage' , 'name', 'role', 
            'vendor', 'countVendor', 'countActivevendor'));
        }
    }

    public function vendorProfile(Request $request, $vendorID){
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $status = DB::table('vendor')->where('vendor.id', $vendorID)
            ->select('*')->pluck('vendor_status')->first();

            $vendorLogo = Vendor::where('id', $vendorID)
            ->get('vendor_logo');

            $vendorRef = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('vendor_ref')->first();
           
            $vendorName = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('vendor_name')->first();

            $vendorStoreType = DB::table('vendor')->where('vendor.id', $vendorID)
            ->join('restaurant_type', 'restaurant_type.id', '=', 'vendor.restaurant_type')
            ->select('restaurant_type.restaurant_type')->pluck('restaurant_type')->first();

            $vendorFoodType = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('food_type')->first();

            $vendorNumberOfLocation = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('number_of_store_locations')->first();

            $vendorDeliveryTime = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('delivery_time')->first();

            $vendorAddress = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('address')->first();

            $vendorState = DB::table('vendor')->where('vendor.id', $vendorID)
            ->join('state', 'state.id', '=', 'vendor.state_id')
            ->select('state.state')->pluck('state')->first();

            $vendorCountry = DB::table('vendor')->where('vendor.id', $vendorID)
            ->join('country', 'country.id', '=', 'vendor.country_id')
            ->select('country.country')->pluck('country')->first();

            $vendorPhone = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('contact_phone')->first();

            $vendorEmail = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('email')->first();

            $vendorFname = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('contact_fname')->first();

            $vendorLname = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('contact_lname')->first();

            $vendorBank = DB::table('vendor')->where('vendor.id', $vendorID)
            ->join('banks', 'banks.code', '=', 'vendor.bank_name')
            ->select('banks.name')->pluck('name')->first();

            $vendorAccountName = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('account_name')->first();

            $vendorAccountNumber = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('account_number')->first();

            $vendorPlatforms = SalesPlatform::join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
            ->join('platforms', 'platforms.name', 'sales_platform.platform_name')
            ->where('vendor.id', $vendorID)
            ->where('sales_platform.deleted_at', null)
            ->get(['sales_platform.vendor_status', 'sales_platform.id',
            'sales_platform.platform_name',
            'sales_platform.platform_ref', 'platforms.img_url']);


            return view('vendormanager.vendor-profile', compact('role', 'name', 
            'vendorLogo', 'vendorRef', 'vendorName', 'vendorStoreType',
            'vendorFoodType', 'vendorPhone', 'vendorEmail', 'vendorFname',
            'vendorLname', 'vendorAddress', 'vendorBank', 'vendorNumberOfLocation',
            'vendorDeliveryTime', 'vendorState', 'vendorCountry', 'vendorAccountName',
            'vendorAccountNumber', 'vendorPlatforms', 'status', 'vendorID'));
        }
    }
    public function editVendor(Request $request, $id){
        if( Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $selectBankName = BankList::all();
            $vendor = Vendor::find($id);

            $vendorBank = DB::table('vendor')->where('vendor.id', $id)
            ->join('banks', 'banks.code', '=', 'vendor.bank_name')
            ->select('banks.name')->pluck('name')->first();

            return view('vendormanager.edit-vendor', compact('vendor', 'vendorBank', 'selectBankName', 'role', 'name')); 
        }
          else { return Redirect::to('/login');
        }
  }

    public function updateVendor(Request $request, $id)
    {
        $this->validate($request, [
            'vendor_name'    => 'max:255',
            'store_area'     => 'max:255',
            'first_name'    => 'max:255',
            'last_name'     => 'max:255',
            'email'         => 'max:255',  
            'phone'         => 'max:255',
            'bank_name'     => 'max:255',
            'account_name'  => 'max:255',
            'account_number' => 'max:255',
            ]);
            $vendor = Vendor::find($id);
            $vendor->vendor_name    = $request->vendor_name;
            $vendor->store_area     = $request->store_area;
            $vendor->contact_fname  = $request->first_name;
            $vendor->contact_lname  = $request->last_name;
            $vendor->email          = $request->email;
            $vendor->contact_phone  = $request->phone;
            $vendor->bank_name      = $request->bank_name;
            $vendor->account_name   = $request->account_name;
            $vendor->account_number = $request->account_number;
            $vendor->update();

            if($vendor){
                return redirect()->back()->with('update-vendor', 'Record Updated');
  
            }
            else{
                return redirect()->back()->with('update-error', 'Opps! something went wrong'); 
            }
    }

    public function foodMenu(Request $request){
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();
        
            $vendor = Vendor::all();
        
            return view('vendormanager.food-menu', compact('role', 'name', 'vendor'));

        }
    }

    public function addFoodMenu(Request $request){
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
                'vendor'    => 'required|max:255',
            ]);

            $addMenu = new FoodMenu();
            $addMenu->added_by      = $user_id;
            $addMenu->item          = $request->item;
            $addMenu->price         = $request->price;
            $addMenu->vendor_id     = $request->vendor;
            $addMenu->save();
            if($addMenu){

                return redirect('food-menu')->with('add-menu', 'Menu  successfully added');
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

    public function allFoodMenu(Request $request){
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $foodMenu = DB::table('food_menu')
            ->join('vendor', 'vendor.id', '=','food_menu.vendor_id')
            ->join('users', 'users.id', '=','food_menu.added_by')
            ->where('food_menu.deleted_at', null)
            ->where('food_menu.price', '!=', null)
            ->where('food_menu.item', '!=', null)
            ->select(['vendor.vendor_name', 'food_menu.*', 'users.fullname'])
            ->orderBy('food_menu.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('vendor.vendor_name', 'LIKE', '%'.$search.'%')
                ->orWhere('food_menu.item', 'LIKE', '%'.$search.'%')
                    ->orWhere('food_menu.price', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'food')->appends(['per_page'   => $perPage]);
            $pagination = $foodMenu->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('vendormanager.all-food-menu',  compact(
                    'perPage', 'name', 'role', 'foodMenu'))->withDetails($pagination);     
                } 
            else{return redirect()->back()->with('food-status', 'No record order found'); }
            
            return view('vendormanager.all-food-menu', compact('perPage', 'role', 'name','foodMenu', 'vendor'));


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
    public function bulkDeleteFoodMenu(Request $request){
        $today = Carbon::now();
        $ids = $request->ids;
        DB::table("food_menu")->whereIn('id',explode(",",$ids))
        ->update([
            'deleted_at' => $today
        ]);
        return response()->json(['success'=>"Menu Deleted successfully."]);
    }

    public function setupApprovedVendor(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $platform = Platforms::all();
        $vendor = Vendor::where('vendor_status', 'approved')
        ->where('deleted_at', '=', null)
        ->get();

        return view('admin.setup-vendor', compact('role', 'name', 'platform', 'vendor'));
    }

    public function setup(Request $request){
        $this->validate($request, [ 
            'platform'      => 'required|string|max:255',
            'vendor'        => 'required|string|max:255',
            'reference'     => 'required|max:255',
        ]);

        $checkVendorStatus = SalesPlatform::where('vendor_id', $request->vendor)
        ->where('platform_name', $request->platform)
        ->get('vendor_status');

        $checkVendorCode = SalesPlatform::where('vendor_id', $request->vendor)
        ->where('platform_name', $request->platform)
        ->get('platform_ref');

        $status = 'active';
        if(empty($checkVendorCode && $checkVendorStatus == 'inactive')){
            $setupVendor = DB::table('sales_platform')
            ->where('vendor_id', $request->vendor)
            ->where('platform_name', $request->platform)
            ->update([
                'vendor_status' => $status,
                'platform_ref'  => $request->reference
            ]);

            $vendorName = Vendor::where('id', $request->vendor)
            ->get('*')->pluck('vendor_name')->first();

            return redirect('all-vendor')->with('setup-vendor', 'Setup successful for ' .$vendorName. ' on ' .$request->platform);
        }
        else{
            return redirect()->back()->with('setup-error', 'Opps something went wrong');
        
        }
    }
    
    
    public function createInvoice(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 12;
        $search = $request->input('search');

        $platforms = Platforms::all();

        $vendor = DB::table('vendor')
        ->where('deleted_at', '=', null)
        ->where('vendor_status', 'approved')
        ->select(['*'])
        ->orderBy('created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor_name', 'LIKE', '%'.$search.'%')
               ->orderBy('created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'vendor'
        )->appends(['per_page'   => $perPage]);
    
        $pagination = $vendor->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.create-invoice',  compact(
                'perPage', 'name', 'role', 'vendor'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('vendor-status', 'No record order found'); }
        return view('admin.create-invoice',  compact('perPage', 'name', 'role', 'vendor'));
    }

    public function  uploadInvoice(Request $request, $vendorID){
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();
    
            $status = DB::table('vendor')->where('vendor.id', $vendorID)
            ->select('*')->pluck('vendor_status')->first();
    
            $vendorLogo = Vendor::where('id', $vendorID)
            ->get('vendor_logo');
    
            $vendorRef = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('vendor_ref')->first();
               
            $vendorName = DB::table('vendor')->where('id', $vendorID)
            ->select('*')->pluck('vendor_name')->first();
    
            $vendorPlatforms = SalesPlatform::join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
            ->join('platforms', 'platforms.name', 'sales_platform.platform_name')
            ->where('vendor.id', $vendorID)
            ->where('sales_platform.deleted_at', null)
            ->where('sales_platform.vendor_status', 'active')
            ->get(['sales_platform.platform_name', 'platforms.img_url']);

            return view('admin.upload-invoice', compact('role', 'name', 
            'vendorLogo', 'vendorRef', 'vendorName', 'vendorPlatforms', 'status', 
            'vendorID'));
            }
    }

    public function storeInvoice(Request $request){
         // Validate the uploaded file
         $request->validate([
          'platform'    => 'required|string|max:255',
          'vendor'      => 'required|string|max:255',
          'file'        => 'required|mimes:xlsx,xls',
        ]);
       
        $file           = $request->file('file');
        $vendor_id      = $request->vendor;
        $platform_id    = $request->platform;
        //send to tempoary order for merging
        $import =  Excel::import(new OrderList($vendor_id, $platform_id), $file);   
  
      if($import){
        $platform = $request->platform_name;
        return redirect()->back()->with('invoice-status', $platform. ' order imported successfully!');
      }
      else{
        return redirect()->back()->with('invoice-error', 'Opps! something went wrong');
      }
    }
    
    public function mergeInvoice(Request $request){
        $vendor = $request->vendor;
        $today = Carbon::today();
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999);
        $invoice_ref ='L'.str_shuffle($pin);

        $tempOrder = TempOrder::whereDate('created_at', $today)
        ->where('vendor_id', $vendor)->get();
        //$glovoComm =  each order_amount * 0.22 ;
        //$chowdeckComm = 0;
        if($tempOrder->count() >= 1){
            foreach($tempOrder as $order){
                $storeOrder = new Orders();
                $storeOrder->invoice_ref     = $invoice_ref; 
                $storeOrder->added_by        = $order->added_by;
                $storeOrder->platform_id     = $order->platform_id;
                $storeOrder->vendor_id       = $order->vendor_id;
                $storeOrder->order_ref       = $order->order_ref;
                $storeOrder->order_amount    = $order->order_amount;
                $storeOrder->food_menu_id    = $order->food_menu_id;
                $storeOrder->food_price      = $order->food_price;
                $storeOrder->extra           = $order->extra;
                $storeOrder->description     = $order->description;
                $storeOrder->delivery_date   = $order->delivery_date;
                $storeOrder->save();

                $getplatform = Platforms::where('id', $storeOrder->platform_id)->pluck('name');
                $platform = implode('', json_decode($getplatform));

                // $localEatsGlovoComm     = (int)$storeOrder->order_amount - $platformComm - $storeOrder->food_price - $storeOrder->extra ;
                // $localEatsChowdeckComm  = (int)$storeOrder->order_amount - $platformComm - $storeOrder->food_price - $storeOrder->extra ;

                $commission = new Commission();
                $commission->order_id               = $storeOrder->id;
                $commission->vendor_id              = $vendor;
                $commission->platform_id            = $order->platform_id;
                $commission->platform_name          = $platform;
                $commission->save();

                $insert = new MergeInvoice();
                $insert->vendor_id = $vendor;
                $insert->order_id =  $storeOrder->id;
                $insert->save();
           }
    
            if($insert){
                $countRow =MergeInvoice::where('created_at', $insert->created_at)
                ->count();
                //count the number of order taht was merge to create invoice
                MergeInvoice::where('id', $insert->id)
                ->update([
                'number_of_order_merge' => $countRow
                ]);
                Orders::where('id', $storeOrder->id)
                ->update([
                'number_of_order_merge' => $countRow,
                'payment_status' => 'unpaid',
                ]);
                
                TempOrder::where('vendor_id', $vendor)->delete();
                  
                return redirect('computed-invoice/'.$vendor.'/'.$countRow.'/'.$storeOrder->invoice_ref)->with('invoice', 'Invoices merged'); 
            }
            else{
                return redirect()->back()->with('merge-error', 'Something went wrong');
            }
         }
        else{
            return redirect()->back()->with('merge-error', 'Can not compute empty order (s)');    
           
        }
    }

    public function showMergeInvoices(Request $request, $vendor, $number_of_import,  $invoice_ref){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();
            
            $vendorID = Vendor::where('id', $vendor)
            ->get('*')->pluck('id')->first();

            $vendorName = Vendor::where('id', $vendor)
            ->get('*')->pluck('vendor_name')->first();

            $vendorAddress = DB::table('vendor')->where('id', $vendor)
            ->select('*')->pluck('address')->first();

            $vendorState = DB::table('vendor')->where('vendor.id', $vendor)
            ->join('state', 'state.id', '=', 'vendor.state_id')
            ->select('state.state')->pluck('state')->first();

            $vendorCountry = DB::table('vendor')->where('vendor.id', $vendor)
            ->join('country', 'country.id', '=', 'vendor.country_id')
            ->select('country.country')->pluck('country')->first();

            $vendorPhone = DB::table('vendor')->where('id', $vendor)
            ->select('*')->pluck('contact_phone')->first();

            $vendorEmail = DB::table('vendor')->where('id', $vendor)
            ->select('*')->pluck('email')->first();

            $vendorFname = DB::table('vendor')->where('id', $vendor)
            ->select('*')->pluck('contact_fname')->first();

            $vendorLname = DB::table('vendor')->where('id', $vendor)
            ->select('*')->pluck('contact_lname')->first();

            $totalComm = DB::table('orders')
            ->leftJoin('commission', 'orders.id', '=', 'commission.order_id')
            ->where('orders.vendor_id', $vendor)
            ->where('orders.invoice_ref', $invoice_ref)
             ->where('orders.deleted_at', null)
             ->sum('commission.localeats_comm');

             $totalPlatformComm = DB::table('orders')
             ->leftJoin('commission', 'orders.id', '=', 'commission.order_id')
               ->where('orders.vendor_id', $vendor)
               ->where('orders.invoice_ref', $invoice_ref)
               ->where('orders.deleted_at', null)
               ->sum('commission.platform_comm');

               $sumAmount = DB::table('orders')
               ->where('orders.vendor_id', $vendor)
                ->where('orders.invoice_ref', $invoice_ref)
                ->where('orders.deleted_at', null)
                ->sum('orders.order_amount');
                //dd($sumAmount );

                $sumFoodPrice = DB::table('orders')
                 ->where('orders.vendor_id', $vendor)
                 ->where('orders.invoice_ref', $invoice_ref)
                 ->where('orders.deleted_at', null)
                 ->sum('orders.food_price');

                 $sumExtra = DB::table('orders')
                 ->where('orders.vendor_id', $vendor)
                  ->where('orders.invoice_ref', $invoice_ref)
                  ->where('orders.deleted_at', null)
                  ->sum('orders.extra');
            //select vendor food price and extra
            $vendorFoodPrice = FoodMenu::where('vendor_id', $vendor)
            ->get();

            $getpayout =  DB::table('orders')
            ->where('vendor_id', $vendor)
            ->where('invoice_ref', $invoice_ref)
            ->get('*')
            ->value('payout');
            $payout = (int)$getpayout;

            $getcommission =  DB::table('orders')
            ->where('vendor_id', $vendor)
            ->where('invoice_ref', $invoice_ref)
            ->get('*')
            ->value('commission');
            $commissionPiad = (int)$getcommission;
            
            $invoiceRef =  DB::table('orders')
            ->where('orders.vendor_id', $vendor)
            ->where('orders.invoice_ref', $invoice_ref)
            ->select('orders.invoice_ref')
            ->pluck('invoice_ref')->first();

            $invoicePaymentStatus =  DB::table('orders')
            ->where('vendor_id', $vendor)
            ->where('invoice_ref', $invoice_ref)
            ->where('payment_status', '!=',  null)
            ->get('payment_status')
            ->pluck('payment_status')->first();
            //dd($invoicePaymentStatus);

            $orders = DB::table('orders')
            ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')
            ->Join('commission', 'orders.id', '=', 'commission.order_id')
            //->leftJoin('merge_invoices', 'orders.id', '=', 'merge_invoices.order_id')
            ->where('orders.vendor_id', $vendor)
            ->where('orders.invoice_ref', $invoice_ref)
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->get(['orders.*', 'platforms.name', 
            'commission.platform_comm',
            'commission.localeats_comm']);
        
        return view('admin.merge-invoice', compact('role', 'name', 'vendorName',
        'vendorAddress','vendorState', 'vendorCountry', 'vendorPhone',
         'vendorEmail', 'vendorFname', 'vendorLname', 'orders',
         'totalComm', 'totalPlatformComm', 'sumAmount', 'sumFoodPrice', 'sumExtra',
        'vendorFoodPrice', 'payout', 'invoiceRef', 'vendorID', 'invoicePaymentStatus',
        'commissionPiad') );
    }

    public function updateMergeInvoiceFood(Request $request){
        $this->validate($request, [ 
            'food_price'          => 'required|max:255',
        ]);
        $amount         = $request->amount;
        $extra          = $request->extra;
        $food_price_id  =  $request->food_price;
        $order_id       = $request->order;
        $vendor         = $request->vendor;

        $platformName = Commission::where('order_id', $order_id)
        ->where('vendor_id', $vendor)
        ->pluck('platform_name')->first();
        
        $foodPrice = DB::table('food_menu')->whereIn('id', $food_price_id)
        ->sum('price');

        $selectFoodPrice = Orders::where('id', $order_id)->pluck('food_price')->first();
        $addFoodPrice =  (int)$selectFoodPrice + $foodPrice ;

        $updateOrder = Orders::where('id', $order_id)
        ->where('vendor_id', $vendor)
        ->update([
            'food_price' => $addFoodPrice,
        ]);
        if($updateOrder){
          
            if($platformName == 'Chowdeck' ){
                $orderAmount = Orders::where('id', $order_id)
                ->where('vendor_id', $vendor)->pluck('order_amount')->first();
                
                $platformComm = '0';
               
                $locaEatsComm = (int)$orderAmount - $platformComm - $addFoodPrice - $extra;
                $updateComm = Commission::where('order_id', $order_id)
                ->where('vendor_id', $vendor)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

               if($platformName == 'Glovo' ){
                $orderAmount = Orders::where('id', $order_id)
                ->where('vendor_id', $vendor)->pluck('order_amount')->first();

                $platformComm = (int)$orderAmount * 0.22;
               
                $locaEatsComm = (int)$orderAmount - $platformComm - $addFoodPrice - $extra;
                $updateComm = Commission::where('order_id', $order_id)
                ->where('vendor_id', $vendor)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }
               $data = 'Update successful' ;
              
             // return response()->json($data);
           
            return redirect()->back()->with('invoice',  $data );
        }
        else{
            $data = [
                'success' => false,
                'message'=> 'Opps! something happen'
              ] ;
              
             // return response()->json($data);
            return redirect()->back()->with('merge-error', 'Opps! something went wrong');
         
        }
    }

    public function updateMergeInvoiceExtra(Request $request){
        $this->validate($request, [ 
            'extra'          => 'required|max:255',
        ]);
        $amount         = $request->amount;
        $extra_id       = $request->extra;
        $foodPrice      =  $request->food_price;
        $order_id       = $request->order;
        $vendor         = $request->vendor;

        $platformName = Commission::where('order_id', $order_id)
        ->where('vendor_id', $vendor)
        ->pluck('platform_name')->first();

        $extra = DB::table('food_menu')->whereIn('id', $extra_id)
        ->sum('price');

       $selectExtra = Orders::where('id', $order_id)->pluck('extra')->first();
       $addExtra =  (int)$selectExtra + $extra ;

     
         $updateOrder = Orders::where('id', $order_id)
         ->where('vendor_id', $vendor)
         ->update([
             'extra'     => $addExtra,
         ]);
         if($updateOrder){

            if($platformName == 'Chowdeck' ){
                $orderAmount = Orders::where('id', $order_id)
                ->where('vendor_id', $vendor)->pluck('order_amount')->first();
                
                $platformComm = '0';
               
                $locaEatsComm = (int)$orderAmount - $platformComm - $foodPrice - $addExtra;
                $updateComm = Commission::where('order_id', $order_id)
                ->where('vendor_id', $vendor)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

               if($platformName == 'Glovo' ){
                $orderAmount = Orders::where('id', $order_id)
                ->where('vendor_id', $vendor)->pluck('order_amount')->first();

                $platformComm = (int)$orderAmount * 0.22;
               
                $locaEatsComm = (int)$orderAmount - $platformComm - $foodPrice - $addExtra;
                $updateComm = Commission::where('order_id', $order_id)
                ->where('vendor_id', $vendor)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

             return redirect()->back()->with('invoice', 'Update successful');
         }
         else{
             return redirect()->back()->with('merge-error', 'Opps! something went wrong');
         }
     }

     public function updateVendorInvoicePayout(Request $request){

        $amount         = $request->amount_payout;
        $order_id       = $request->order;

         $updateOrder = Orders::where('id', $order_id)
         ->update([
             'payout'     => $amount,
         ]);
         if($updateOrder){
            $data = [
                'status' => true,
                'message'=> 'Record updated successfully'
            ];
            return response()->json($data);
             //return redirect()->back()->with('invoice', 'Update successful');
         }
         else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something happen'
            ];
            return response()->json($data);
            //return redirect()->back()->with('merge-error', 'Opps! something went wrong');
          
         }
     }


     public function vendorMergedInvoices(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $orders = DB::table('orders')->distinct()
      // ->join('merge_invoices', 'merge_invoices.number_of_order_merge', '=', 'orders.number_of_order_merge')
        ->join('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->where('orders.deleted_at', null)
        ->where('orders.payment_status', 'unpaid')
        ->orderBy('orders.created_at', 'desc')
        ->select(['orders.*', 
        'vendor.vendor_name', 'vendor.id'])
        ->where(function ($query) use ($search) {  // <<<
        $query->where('orders.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.invoice_ref', 'LIKE', '%'.$search.'%')
               ->orderBy('orders.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'orders'
        )->appends(['per_page'   => $perPage]);
    
        $pagination = $orders->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.vendor-merged-invoices',  compact(
                'perPage', 'name', 'role', 'orders'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('invoice-status', 'No record order found');}
        return view('admin.vendor-merged-invoices', compact('name', 'role', 'orders'));
     }

     public function generateInvoice(Request $request){
        $invoiceRef     = $request->invoice;
        $vendor         = $request->vendor;

        $check = Invoice::where('reference', $invoiceRef)
        ->where('vendor_id', $vendor )
        ->get();

        if(!empty($check)){
            $update = Invoice::where('reference', $invoiceRef)
            ->where('vendor_id', $vendor )
            ->update([
                'reference' => $invoiceRef,
                'vendor_id' => $vendor,
            ]);
             return redirect('invoice/'.$invoiceRef.'/'.$vendor); 
            }
        $generateInvoice = new Invoice();
        $generateInvoice->vendor_id     = $vendor;
        $generateInvoice->reference     = $invoiceRef ;
        $generateInvoice->save();
        if($generateInvoice){
            return redirect('invoice/'.$invoiceRef.'/'.$vendor);        
       }
     }

     public function showInvoice(Request $request, $invoice_ref, $vendor){
       
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $vendorID = Vendor::where('id', $vendor)
        ->get('*')->pluck('id')->first();

        $invoiceRef = Orders::where('vendor_id', $vendor)
        ->where('invoice_ref', $invoice_ref)
        ->get('*')->pluck('invoice_ref')->first();

        $vendorBusinessName = Vendor::where('id', $vendor)
        ->get('*')->pluck('store_name')->first();

        $vendorAddress = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('address')->first();

        $vendorState = DB::table('vendor')->where('vendor.id', $vendor)
        ->join('state', 'state.id', '=', 'vendor.state_id')
        ->select('state.state')->pluck('state')->first();

        $vendorCountry = DB::table('vendor')->where('vendor.id', $vendor)
        ->join('country', 'country.id', '=', 'vendor.country_id')
        ->select('country.country')->pluck('country')->first();

        $vendorPhone = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('contact_phone')->first();

        $vendorEmail = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('email')->first();

        $vendorFname = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('contact_fname')->first();

        $vendorLname = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('contact_lname')->first();

        $vendorAccountNumber = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('account_number')->first();

        $vendorAccountName = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('account_name')->first();

        $vendorBankName = DB::table('vendor')->where('vendor.id', $vendor)
        ->leftjoin('banks', 'banks.code', 'vendor.bank_name')
        ->select('banks.*')->pluck('name')->first();

        $sumFoodPrice = DB::table('orders')
        ->where('orders.vendor_id', $vendor)
        ->where('orders.invoice_ref', $invoice_ref)
        ->where('orders.deleted_at', null)
        ->sum('food_price');

         $sumExtra = DB::table('orders')
         ->where('orders.vendor_id', $vendor)
         ->where('orders.invoice_ref', $invoice_ref)
         ->where('orders.deleted_at', null)
         ->sum('extra');

         $vendorFoodPrice =  $sumFoodPrice + $sumExtra;

         $getpayout =  DB::table('orders')
            ->where('vendor_id', $vendor)
            ->where('invoice_ref', $invoice_ref)
            ->get('*')
            ->value('payout');
            $payout = (int)$getpayout;

         $payment_status = DB::table('orders')
          ->where('orders.vendor_id', $vendor)
         ->where('orders.invoice_ref', $invoice_ref)
         ->where('orders.payment_status', '!=', null)
         ->pluck('payment_status')->first();
  
          $orders = DB::table('orders')
          ->leftJoin('merge_invoices', 'orders.id', '=', 'merge_invoices.order_id')
          ->where('orders.vendor_id', $vendor)
          ->where('orders.invoice_ref', $invoice_ref)
          ->where('orders.order_amount', '!=', null)
          ->where('orders.deleted_at', null)
          ->get(['orders.*']);

          return view('vendor-invoice', compact('role', 'name', 'vendorBusinessName',
            'vendorAddress','vendorState', 'vendorCountry', 'vendorPhone',
            'vendorEmail', 'vendorFname', 'vendorLname', 'orders',
            'sumFoodPrice', 'sumExtra','vendorFoodPrice', 'payout', 
            'payment_status', 'invoice_ref', 'vendor', 
            'vendorAccountNumber', 'vendorAccountName', 'vendorBankName'));

     }


     public function showAllFinalInvoices(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');


        $orders = DB::table('orders')->distinct()
        //->join('merge_invoices', 'orders.number_of_order_merge', '=', 'merge_invoices.number_of_order_merge')
        ->join('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->where('orders.deleted_at', null)
        ->where('orders.payment_status', '!=', null)
        ->orderBy('orders.created_at', 'desc')
        ->select(['orders.*', 
        'vendor.vendor_name', 'vendor.id' ])
        ->where(function ($query) use ($search) {  // <<<
        $query->where('orders.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('vendor.vendor_name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.invoice_ref', 'LIKE', '%'.$search.'%')
               ->orderBy('orders.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'orders'
        )->appends(['per_page'   => $perPage]);

     
        $pagination = $orders->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.vendor-final-invoices',  compact(
                'perPage', 'name', 'role', 'orders'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('invoice-status', 'No record order found');}
        return view('admin.vendor-final-invoices', compact('name', 'role', 'orders'));
     }
 


    public function deleteOrder(Request $request, $id){
        $today = Carbon::now();
        $order = Orders::find($id);
        $order->deleted_at  = $today ;
        $order->update();
        //  $order = Orders::find($id);
        //  $order->delete();
        if($order){
            $data = [
                'status'=> true,
                'message'=> 'Record Deleted'
            ] ;
              
            return response()->json($data);
            //return redirect()->back()->with('invoice', 'Record Deleted');
        }
        else{
             
            $data = [
                'status'=> false,
                'message'=> 'Opps! somthing happend'
            ] ;
              
            return response()->json($data);
            //return redirect()->back()->with('merge-error', 'Opps! something went wrong'); 
        }
    }

    public function resetOrderFoodPrice(Request $request, $id){
        $order = Orders::find($id);
        $order->food_price  = '' ;
        $order->update();

        $extra = Orders::where('id', $id)->pluck('extra')->first();
        $foodPrice = Orders::where('id', $id)->pluck('food_price')->first();

         if($order){

            $platformName = Commission::where('order_id', $id)
            ->pluck('platform_name')->first();

            if($platformName == 'Chowdeck' ){
                $orderAmount = Orders::where('id', $id)
                ->pluck('order_amount')->first();
                
                $platformComm = '0';
               
                $locaEatsComm = (int)$orderAmount - (int)$platformComm - (int)$foodPrice - (int)$extra;
                $updateComm = Commission::where('order_id', $id)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

               if($platformName == 'Glovo' ){
                $orderAmount = Orders::where('id', $id)
                ->pluck('order_amount')->first();

                $platformComm = (int)$orderAmount * 0.22;
               
                $locaEatsComm = (int)$orderAmount - $platformComm - (int)$foodPrice - (int)$extra;
                $updateComm = Commission::where('order_id', $id)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

            return redirect()->back()->with('invoice', 'Reset record sucessful');
        }
        else{
            return redirect()->back()->with('merge-error', 'Opps! something went wrong'); 
        }
    }

    public function resetOrderExtra(Request $request, $id){
        $order = Orders::find($id);
        $order->extra  = '' ;
        $order->update();

        $extra = Orders::where('id', $id)->pluck('extra')->first();
        $foodPrice = Orders::where('id', $id)->pluck('food_price')->first();
         if($order){
            $platformName = Commission::where('order_id', $id)
            ->pluck('platform_name')->first();

            if($platformName == 'Chowdeck' ){
                $orderAmount = Orders::where('id', $id)
                ->pluck('order_amount')->first();
                
                $platformComm = '0';
               
                $locaEatsComm = (int)$orderAmount - (int)$platformComm - (int)$foodPrice - (int)$extra;
                $updateComm = Commission::where('order_id', $id)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

               if($platformName == 'Glovo' ){
                $orderAmount = Orders::where('id', $id)
                ->pluck('order_amount')->first();

                $platformComm = (int)$orderAmount * 0.22;
               
                $locaEatsComm = (int)$orderAmount - $platformComm - (int)$foodPrice - (int)$extra;
                $updateComm = Commission::where('order_id', $id)
                ->update([
                    'platform_comm'      => $platformComm,
                    'localeats_comm'      => $locaEatsComm,
                ]);
        
               }

               
            return redirect()->back()->with('invoice', 'Reset record sucessful');
        }
        else{
            return redirect()->back()->with('merge-error', 'Opps! something went wrong'); 
        }
    } 

    public function exportInvoice(Request $request){
        $invoice_ref = $request->invoice_ref;
        return Excel::download(new ExportOrderList($invoice_ref), 'invoice-'.$invoice_ref.'.xlsx');
    }

    public function sendEmailPdfInvoice(Request $request, $ref){
        $img = $request->img; //get the image string from ajax post
        $getimg = substr(explode(";",$img)[1], 7); //this extract the exact image
        $target= $ref.'-invoice.png'; //rename the image by time
       // $image = file_put_contents(public_path($target), base64_decode($getimg));
        $image = file_put_contents(public_path().'/assets/invoice/' . $target, base64_decode($getimg));
        $path = '/assets/invoice/' . $target;

        $invoice_ref =  $ref;
        $vendor = DB::table('orders')
        ->where('orders.invoice_ref', $invoice_ref)
        ->pluck('vendor_id')->first();

        $vendorEmail = DB::table('vendor')->where('id', $vendor)
        ->select('*')->pluck('email')->first();

        $vendorBusinessName = Vendor::where('id', $vendor)
        ->get('*')->pluck('store_name')->first();
           
        if($image){
            $pdf_path =  $path; 
        }
        else {$pdf_path = "";
        }
        $storeInvoice =  Invoice::updateOrCreate(
            ['reference' => $invoice_ref, 'vendor_id' => $vendor],
            ['invoice_url' => $pdf_path, 'invoice_status' => 'email']
        );
        
        // new Invoice();
        // $storeInvoice->reference       = $invoice_ref;
        // $storeInvoice->vendor_id       = $vendor;
        // $storeInvoice->invoice_url     = $pdf_path;
        // $storeInvoice->invoice_status  = 'email';
        // $storeInvoice->save();

        if($storeInvoice){
            $data = array(
                'vendor_name'     => $vendorBusinessName,
                'email'           => $vendorEmail,      
                );
            $invoicePath = Invoice::where('reference', $invoice_ref)  
            ->get()->pluck('invoice_url')->first();  
            $pathInvoice = public_path($invoicePath);

            $message = new EmailVendorInvoice($data);
            $message ->attach($pathInvoice, [
                'as' => 'invoice-'.$invoice_ref.'.png',
                'mime' => 'image/png',
            ]);
            $sendMail = Mail::to($vendorEmail)
                        ->cc(Auth::user()->email)
                        ->bcc('admin@localeats.africa')
                        ->send($message);
          if($sendMail){
            $jsondata = [
                'status' => true,
                'message'=> 'Email sent successfully'
                ];
                            
                return response()->json($jsondata);
          }
          else{
            $jsondata = [
                'status' => false,
                'message'=> 'Opps! Email Not sent. Check if vendor has email address'
                ];
                            
                return response()->json($jsondata);
          }
        }

    }

    public function addInvoiceRow(Request $request, $invoice_ref){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();
        
        $vendor = $request->vendor;
        $platform = Platforms::all();
        $vendorName = Vendor::where('id', $vendor)
        ->get()->pluck('vendor_name')->first();

        return view('vendormanager.add-invoice-row', compact('role','invoice_ref',
         'vendor', 'platform', 'vendorName'));

    }

    public function storeAddNewInvoiceRow(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();
        
        $request->validate([
            'item'                  => 'required',
            'order_reference'       => 'required|string|max:255',
            'order_amount'          => 'required|string|max:255',
            'delivery_date'         => 'required|string|max:255',
            'platform'              => 'required|string|max:255',
          ]);

          $invoice_ref = $request->invoice_ref;
          $vendor = $request->vendor;

          $platformName = Platforms::where('id', $request->platform)
          ->get()->pluck('name')->first();

          $storeOrder = new Orders();
          $storeOrder->invoice_ref     = $invoice_ref; 
          $storeOrder->added_by        = $user_id;
          $storeOrder->platform_id     = $request->platform;
          $storeOrder->vendor_id       = $vendor;
          $storeOrder->order_ref       = $request->order_reference;
          $storeOrder->order_amount    = $request->order_amount;
          $storeOrder->description     = $request->item;
          $storeOrder->delivery_date   = $request->delivery_date;
          $storeOrder->save();

          $commission = new Commission();
          $commission->order_id               = $storeOrder->id;
          $commission->vendor_id              = $vendor;
          $commission->platform_id            = $request->platform;
          $commission->platform_name          = $platformName;
          $commission->save();

        

        if($commission){
              //count the number of order taht was merge to create invoice
            $countRow =Orders::where('invoice_ref', $invoice_ref)
            ->count();

            $numberOfRow = $countRow - 1;

            Orders::where('number_of_order_merge', $numberOfRow)
            ->where('invoice_ref', $invoice_ref)
            ->update([
            'number_of_order_merge' => $countRow,
            'payment_status' => 'unpaid',
            ]);

            $insert = new MergeInvoice();
            $insert->vendor_id              = $vendor;
            $insert->order_id               =  $storeOrder->id;
            $insert->number_of_order_merge  = $countRow;
            $insert->save();

       

            return redirect('computed-invoice/'.$vendor.'/'.$numberOfRow.'/'.$invoice_ref)->with('invoice', 'New Row Added'); 
        }
        else{
            return redirect()->back()->with('merge-error', 'Something went wrong');
        }

    }

    //Cashier
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
        ->orderBy('expense_date', 'desc')
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
        //else{return redirect()->back()->with('expenses-status', 'No record order found'); }

        return view('cashier.expenses',  compact('name', 'role', 
         'vendorName','expensesList', 'vendor_id', 'perPage', 'expenses'));
    }

    public function addExpensesList(Request $request){
        $this->validate($request, [ 
            'vendor'  => 'required|max:255',
            'item'   => 'required|string|max:255',   
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
            'price'         => 'required|string|max:255',  
            'date'          => 'required|string|max:255'       
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
        $expenses->expense_date     = date("Y-m-d", strtotime($request->date));
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
        ->where('item', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get();

        $vendorSwallow = OfflineFoodMenu::where('vendor_id', $vendor_id)
        ->where('swallow', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get('swallow', 'id');

        $vendorSoup= OfflineFoodMenu::where('vendor_id', $vendor_id)
        ->where('soup', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get('soup', 'id');

        $vendorProtein= OfflineFoodMenu::where('vendor_id', $vendor_id)
        ->where('protein', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get('protein', 'id');

        $vendorOthersFoodItem= OfflineFoodMenu::where('vendor_id', $vendor_id)
        ->where('others', '!=', null)
        ->orderBy('created_at', 'desc')
        ->get('others', 'id');

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $sales = OfflineSales::where('vendor_id', $vendor_id)
        ->where('deleted_at', '=', null)
        ->orderBy('sales_date', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('sales_item', 'LIKE', '%'.$search.'%')
        ->orWhere('price', 'LIKE', '%'.$search.'%')
        ->orWhere('sales_date', 'LIKE', '%'.$search.'%');
        })
        ->paginate($perPage)->appends(['per_page'   => $perPage]);
        $pagination = $sales->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('cashier.sales',  compact('name', 'role', 
                'vendorName','salesList', 'vendor_id', 'perPage', 'sales',
                'vendorSwallow', 'vendorSoup', 'vendorProtein', 'vendorOthersFoodItem'))->withDetails( $pagination );     
            } 
        // else{return redirect()->back()->with('expenses-status', 'No record order found'); }

        return view('cashier.sales',  compact('name', 'role', 
        'vendorName','salesList', 'vendor_id', 'sales', 'perPage', 
        'vendorSwallow', 'vendorSoup', 'vendorProtein', 'vendorOthersFoodItem'));
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
            'price'         => 'required|string|max:255', 
            'date'          => 'required|string|max:255'         
        ]);
        // $foodItem = new OfflineFoodMenu();
        // $foodItem->vendor_id    = $request->vendor;
        // $foodItem->item         = $request->item;
        // $foodItem->added_by     = Auth::user()->id;
        // $foodItem->save();
        if(empty($request->soup)){
            $soup = ' ';
        }
        else{
            $soup = $request->soup; 
        }

        if(empty($request->swallow)){
            $swallow = ' ';
        }
        else{
            $swallow = $request->swallow; 
        }

        if(empty($request->protein)){
            $protein = ' ';
        }
        else{
            $protein = $request->protein; 
        }

        if(empty($request->others)){
            $others = ' ';
        }
        else{
            $others = $request->others; 
        }

        $salesArray = array_filter($soup);
        foreach($salesArray  as $key => $value){
            $salesItem =[
                'soup_qty'      =>$request->soup_qty[$key],
                'soup'          => 'plate of '. $salesArray[$key],
                'swallow_qty'   =>$request->swallow_qty[$key],
                'swallow'       =>$swallow [$key],
                'protein_qty'   =>$request->protein_qty[$key],
                'protein'       =>$protein[$key],
                'others_qty'    =>$request->others_qty[$key],
                'others'        =>$others[$key],
                ] ;
        }

       // dd(json_encode($salesItem));
        $sales = new OfflineSales();
        $sales->vendor_id           = $request->vendor;
        $sales->swallow             =  $salesItem['swallow'];
        $sales->swallow_qty         =  $salesItem['swallow_qty'];
        $sales->soup                =  $salesItem['soup'];
        $sales->soup_qty            =  $salesItem['soup_qty'];
        $sales->protein             =  $salesItem['protein'];
        $sales->protein_qty         =  $salesItem['protein_qty'];
        $sales->others              =  $salesItem['others'];
        $sales->others_qty          =  $salesItem['others_qty'];
        //$sales->sales_item          = json_encode($salesItem);
        $sales->price               = $request->price;
        $sales->added_by            = Auth::user()->id;
        $sales->sales_date          = date("Y-m-d", strtotime($request->date));
        $sales->save();

        if($sales){
            return redirect()->back()->with('sales-status', 'You have successfully added a Sales');
        }
        else{
            return redirect()->back()->with('sales-error', 'Opps! something happend');
        
        }
    }
}//class