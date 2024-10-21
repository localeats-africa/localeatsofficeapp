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
use App\Models\State;
use App\Models\Role;
use App\Models\Level;
use App\Models\MergeInvoice;
use App\Models\Commission;
use App\Mail\NewUserEmail;
use App\Imports\OrderList;
use App\Imports\FoodMenuImportClass;
use App\Imports\OrdersImportClass;
use App\Imports\ImportExpensesList;
use App\Imports\ImportOfflineFoodMenu;
use App\Exports\ExportOfflineFoodMenu;
use App\Models\Invoice;
use App\Models\Payout;
use App\Models\ExpensesList;
use App\Models\OfflineSales;
use App\Models\VendorExpenses;
use App\Models\OfflineFoodMenu;
use App\Models\MultiStoreRole;
use App\Models\MultiStore;
use App\Models\SubStore;
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
        $weekStartMonday = Carbon::now()->startOfWeek();// Monday
        $weekEndSunday = Carbon::now()->endOfWeek(); //Snnday
        //current week
        $startOfWeek = $weekStartMonday->format('Y-m-d');
        $endOfWeek =   $weekEndSunday->format('Y-m-d');

        $today = Carbon::now()->format('Y-m-d');
        $currentYear =  Carbon::now()->year;

        $sevenDaysBack = Carbon::now()->subDays(7)->startOfDay();
        $lastSevenDays  =  date('Y-m-d', strtotime($sevenDaysBack));
    
        //dd();
        $allOrderStart = DB::table('orders')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->whereDate('delivery_date', '<=', $today) 
         ->get()->pluck('delivery_date')->first();

        $allOrderEnd = DB::table('orders')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->whereDate('delivery_date', '<=', $today) 
        ->get()->pluck('delivery_date')->last();
        
        $orderStart = date("d-M-Y ", strtotime($allOrderStart)) ;
        $orderEnd = date("d-M-Y ", strtotime($allOrderEnd)) ;

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
      
        $averageWeeklySales = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->whereDate('delivery_date', '=', $lastSevenDays)   
        ->sum('order_amount');

        $countimportOrder = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count();

        $pastInvoiceNumberOfOrders = Orders::where('past_number_of_orders', '!=', null)
        ->sum('past_number_of_orders');
        //count row
        $pastInvoiceOrders = Orders::where('past_number_of_orders', '!=', null)
        ->count();

        $numberOfOrders = $countimportOrder  + $pastInvoiceNumberOfOrders;
        $countAllOrder =   $numberOfOrders  - $pastInvoiceOrders ;

        $getOrderItem = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('description')->pluck('description');

        $pastInvoicePlates = Orders::where('past_number_of_plates', '!=', null)
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->sum('past_number_of_plates');
       // dd($pastInvoicePlates);

        $string =  $getOrderItem;
        $substring = 'plate';
        $countPlateImportOrder = substr_count($string, $substring);
        $countAllPlate =   $countPlateImportOrder + $pastInvoicePlates ;

        $countPlatformWhereOrderCame = DB::table('orders')
        ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')->distinct()
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->count('platforms.id');

        $sumAllOrders = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
        ->sum('order_amount'); 

        $sumGlovoComm = DB::table('commission')
        ->join('orders', 'orders.id', 'commission.order_id')
        ->where('orders.deleted_at', null)
        ->where('orders.food_price', '!=', null)
        ->sum('commission.platform_comm');

        //$commission = (int)$sumAllOrders - (int)$payouts ;
        //$averageWeeklyComm =$averageWeeklySales - $averageWeeklyPayouts ;

        $commissionImported =  DB::table('commission')
        ->join('orders', 'orders.id', 'commission.order_id')
        ->where('orders.deleted_at', null)
        ->where('orders.food_price', '!=', null)
        ->sum('commission.localeats_comm');

        $pastInvoiceCommission = Orders::where('past_invoice_commission', '!=', null)
        ->sum('past_invoice_commission');

        $commission = $commissionImported  + $pastInvoiceCommission ;
        //commission Paid
        $commissionPaidImportedInvoice = DB::table('orders')->sum('commission');
        $pastPaidCommision = Orders::where('past_invoice_commission', '!=', null)
        ->sum('past_paid_commission');

        $commissionPaid = $commissionPaidImportedInvoice + $pastPaidCommision;

        $averageWeeklyCommissionPaid = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
       // ->where('payout', '!=', null)
        //->whereDate('updated_at', '>=', $lastSevenDays)   
        ->whereDate('updated_at', '=', $lastSevenDays)  
        ->sum('commission');

        $averageWeeklyComm = DB::table('commission')
        ->join('orders', 'orders.id', 'commission.order_id')
        ->where('orders.deleted_at', null)
        ->whereDate('commission.created_at', '=', $lastSevenDays)   
        ->sum('commission.localeats_comm');

        $sumFoodPrice = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->sum('food_price');

        $sumExtra =  DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->sum('extra');

        $pastInvoiceVendorPrice = Orders::where('past_invoice_vendor_price', '!=', null)
        ->sum('past_invoice_vendor_price');

        $vendorFoodPrice =  $sumFoodPrice + $sumExtra + $pastInvoiceVendorPrice;
        
        $payoutsImported = DB::table('orders')
        ->where('deleted_at', null)
        ->where('order_amount', '!=', null)
        ->where('order_ref', '!=', null)
        ->sum('payout');

        $pastPayout = DB::table('orders')
        ->where('deleted_at', null)
        ->where('order_amount', '!=', null)
        ->where('order_ref', '!=', null)
        ->sum('past_invoice_payout');

        $payouts =  $payoutsImported + $pastPayout;

        $averageWeeklyPayouts = DB::table('orders')
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
       ->where('payout', '!=', null)
        ->whereDate('updated_at', '=', $lastSevenDays)    
        ->sum('payout');

        $platformOrders = DB::table('orders')
        ->join('platforms', 'platforms.id', '=', 'orders.platform_id')->distinct()
        ->where('platforms.deleted_at', null)
        ->get(['platforms.*']);
    
        $chartYearlyTotalSales = Orders::select(
        \DB::raw('YEAR(delivery_date) as year'),)
        ->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
        ->groupby('year')
        ->get();

        // $month = [];
        // for ($m=1; $m<=12; $m++) {
        //     $month[] = date('M', mktime(0,0,0,$m, 1, date('Y')));
        // }

        $default = collect([
            "Jan" => 0,
            "Feb" => 0,
            "Mar" => 0,
            "Apr" => 0,
            "May" => 0,
            "Jun" => 0,
            "Jul" => 0,
            "Aug" => 0,
            "Sep" => 0,
            "Oct" => 0,
            "Nov" => 0,
            "Dec" => 0
          ]);
          
         ;

        // Monthly Sales  Chart%Y/%m  %M %M %Y

        $chartMonths = Orders::select(
            \DB::raw("COUNT(*) as total_sales"), 
            \DB::raw('DATE_FORMAT(delivery_date,"%b") as month'),
            )->where('deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->where('orders.food_price', '!=', null)
          // ->orderBy('month','desc')
            ->groupBy('month')
            ->pluck('month');

        $chartMonthlyTotalSales = Orders::select(
        \DB::raw("COUNT(*) as total_sales"), 
        \DB::raw('DATE_FORMAT(delivery_date,"%m/%Y") as month'),
        \DB::raw('SUM(order_amount) as sales_volume'),
        )->where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
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

        $chowdeckOrderCount= DB::table('orders')
        ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->where('platforms.name', 'chowdeck')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('orders.platform_id')->count();

        $glovoOrderCount= DB::table('orders')
        ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->where('platforms.name', 'glovo')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('orders.platform_id')->count();

        $edenOrderCount= DB::table('orders')
        ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->where('platforms.name', 'edenlife')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('orders.platform_id')->count();

        $manoOrderCount= DB::table('orders')
        ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->where('platforms.name', 'mano')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->get('orders.platform_id')->count();

        // pie chart
        $chowdeckSalesPercentageChart = $chowdeckOrderCount / $countAllOrder * 100;
        $glovoSalesPercentageChart = $glovoOrderCount / $countAllOrder * 100;
        $edenSalesPercentageChart = $edenOrderCount / $countAllOrder * 100;
        $manoSalesPercentageChart = $manoOrderCount / $countAllOrder * 100;

        $piechartData = [            
        'label' => ['Chowdeck', 'Glovo', 'Eden', 'Mano'],
        'data' => [round($chowdeckSalesPercentageChart) , round($glovoSalesPercentageChart),  round($edenSalesPercentageChart), round( $manoSalesPercentageChart)] ,
        ];
        
    //sales for barchart
    $chowdeckOrder =  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
    ->select(
        \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
        \DB::raw('SUM(orders.order_amount) as sales'),
        \DB::raw('COUNT(orders.order_amount) as count'),
        )
        ->where('platforms.name', 'chowdeck')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
       // ->whereYear('orders.delivery_date', '=', Carbon::now()->year)
        ->groupby('month')
        ->orderBy('month', 'asc')
        ->get();
    $barChartChowdeckSales = Arr::pluck($chowdeckOrder, 'sales');
    $barChartChowdeckSCount = Arr::pluck($chowdeckOrder, 'count');

    $glovoOrder = Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
    ->select(
        \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
        \DB::raw('SUM(orders.order_amount) as sales'),
        \DB::raw('COUNT(orders.order_amount) as count'),
        )
        ->where('platforms.name', 'glovo')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
        //->whereYear('orders.delivery_date', '=', Carbon::now()->year)
        ->groupby('month')
        ->orderBy('month', 'asc')
        ->get();
        $barChartGlovoSales = Arr::pluck($glovoOrder, 'sales');

    $edenOrder=  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
    ->select(
        \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
        \DB::raw('SUM(orders.order_amount) as sales'),
        \DB::raw('COUNT(orders.order_amount) as count'),
        )
        ->where('platforms.name', 'edenlife')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
        //->whereYear('orders.delivery_date', '=', Carbon::now()->year)
        ->groupby('month')
        ->orderBy('month', 'asc')
        ->get();
        $barChartEdenSales = Arr::pluck($edenOrder, 'sales');

    $manoOrder =  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->select(
        \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
        \DB::raw('SUM(orders.order_amount) as sales'),
        \DB::raw('COUNT(orders.order_amount) as count'),
        )
        ->where('platforms.name', 'mano')
        ->where('orders.deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->where('orders.food_price', '!=', null)
        ->groupby('month')
        ->orderBy('month', 'asc')
        ->get();
    $barChartManoSales = Arr::pluck($manoOrder, 'sales');
  
    $barChartData = [
        'months'        =>  $chartSalesMonth,
        'chocdekSales'  =>  $barChartChowdeckSales,
        'glovoSales'    =>  $barChartGlovoSales,
        'edenSales'     =>  $barChartEdenSales,
        'manoSales'     =>  $barChartManoSales,
    ]; 
    
        return view('admin.admin', compact('name', 'role', 'countVendor',
         'countActiveVendor', 'countPlatforms', 'activePlatform',
        'countPlatforms',  'payouts', 'commission',   'sumAllOrders', 
        'countAllOrder', 'countPlatformWhereOrderCame',
        'countAllPlate', 'commissionPaid', 'orderStart', 'orderEnd',
        'averageWeeklySales', 'averageWeeklyPayouts', 'averageWeeklyCommissionPaid',
        'averageWeeklyComm', 'data', 'salesYear', 'platformOrders',
        'chowdeckOrderCount','glovoOrderCount', 'edenOrderCount', 'currentYear',
        'chowdeckSalesPercentageChart', 'glovoSalesPercentageChart', 
        'edenSalesPercentageChart', 'piechartData' ,  'barChartData',
        'sumGlovoComm', 'vendorFoodPrice', 'manoOrderCount', 
        'manoSalesPercentageChart','monthlist'));
      }
    }

    public function adminFilterDashboard(Request $request){
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
        
        $countVendor = Vendor::all();
        $countActiveVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->where('sales_platform.vendor_status', 'active')
        ->get('sales_platform.vendor_id');

         //filter dashboard Start here
         $startDate      =   date("Y-m-d", strtotime($request->from)) ;
         $endDate        =  date("Y-m-d", strtotime($request->to));
 
         $sumAllOrders = DB::table('orders')
         ->where('deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->where('orders.food_price', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('order_amount');

        $countimportOrder = Orders::where('deleted_at', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->whereDate('delivery_date', '>=', $startDate)                                 
        ->whereDate('delivery_date', '<=', $endDate) 
        ->count();

        $pastInvoiceNumberOfOrders = Orders::where('past_number_of_orders', '!=', null)
        ->whereDate('delivery_date', '>=', $startDate)                                 
        ->whereDate('delivery_date', '<=', $endDate) 
        ->sum('past_number_of_orders');
        //count row
        $pastInvoiceOrders = Orders::where('past_number_of_orders', '!=', null)
        ->whereDate('delivery_date', '>=', $startDate)                                 
        ->whereDate('delivery_date', '<=', $endDate) 
        ->count();

        $numberOfOrders = $countimportOrder  + $pastInvoiceNumberOfOrders;
        $countAllOrder =   $numberOfOrders  - $pastInvoiceOrders ;

         $sumFoodPrice = DB::table('orders')
         ->where('deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('food_price');
 
         $sumExtra =  DB::table('orders')
         ->where('deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('extra');
 
         $pastInvoiceVendorPrice = Orders::where('past_invoice_vendor_price', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('past_invoice_vendor_price');
 
         $vendorFoodPrice =  $sumFoodPrice + $sumExtra + $pastInvoiceVendorPrice;
         
         $payoutsImported = DB::table('orders')
         ->where('deleted_at', null)
         ->where('order_amount', '!=', null)
         ->where('order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('payout');
 
         $pastPayout = DB::table('orders')
         ->where('deleted_at', null)
         ->where('order_amount', '!=', null)
         ->where('order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('past_invoice_payout');

         $payouts =  $payoutsImported + $pastPayout;
 
         $sumGlovoComm = DB::table('commission')
         ->join('orders', 'orders.id', 'commission.order_id')
         ->where('orders.deleted_at', null)
         ->where('orders.food_price', '!=', null)
         ->whereDate('orders.delivery_date', '>=', $startDate)                                 
         ->whereDate('orders.delivery_date', '<=', $endDate) 
         ->sum('commission.platform_comm');

         $pastInvoicePlates = Orders::where('past_number_of_plates', '!=', null)
         ->where('deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->sum('past_number_of_plates');
    
         $getOrderItem = DB::table('orders')
         ->where('deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->get('description')->pluck('description');
 
         $string =  $getOrderItem;
         $substring = 'plate';
         $countPlateImportOrder = substr_count($string, $substring);
         $countAllPlate =   $countPlateImportOrder + $pastInvoicePlates ;
 
         $countPlatformWhereOrderCame = DB::table('orders')
         ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')->distinct()
         ->where('orders.deleted_at', null)
         ->where('orders.order_amount', '!=', null)
         ->where('orders.order_ref', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate) 
         ->count('platforms.id');
 
         $commissionImported =  DB::table('commission')
         ->join('orders', 'orders.id', 'commission.order_id')
         ->where('orders.deleted_at', null)
         ->where('orders.food_price', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate)
         ->sum('commission.localeats_comm');
 
         $pastInvoiceCommission = Orders::where('past_invoice_commission', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate)
         ->sum('past_invoice_commission');
 
         $commission = $commissionImported  + $pastInvoiceCommission ;
         //commission Paid
         $commissionPaidImportedInvoice = DB::table('orders')
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate)
         ->sum('commission');

         $pastPaidCommision = Orders::where('past_invoice_commission', '!=', null)
         ->whereDate('delivery_date', '>=', $startDate)                                 
         ->whereDate('delivery_date', '<=', $endDate)
         ->sum('past_paid_commission');
 
         $commissionPaid = $commissionPaidImportedInvoice + $pastPaidCommision;

         $chartYearlyTotalSales = Orders::select(
            \DB::raw('YEAR(delivery_date) as year'),)
            ->where('deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->where('orders.food_price', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->groupby('year')
            ->get();
    
            $chartMonthlyTotalSales = Orders::select(
            \DB::raw("COUNT(*) as total_sales"), 
            \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(order_amount) as sales_volume'),
            )->where('deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->where('orders.food_price', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();

            $chartSalesMonth = Arr::pluck($chartMonthlyTotalSales, 'month');
            $chartSalesVolume = Arr::pluck($chartMonthlyTotalSales, 'sales_volume');
            $chartSalesTotal = Arr::pluck($chartMonthlyTotalSales, 'total_sales');
    
            $monthlist = array_map(fn($month) => Carbon::create(null, $month)->format('M'), range(1, 12));
            $salesYear =  Arr::pluck($chartYearlyTotalSales, 'year');
            $data = [
             'month' =>  $chartSalesMonth ,
             'sales' =>  $chartSalesVolume,
             'total' =>  $chartSalesTotal,
            ];
    
            $chowdeckOrderCount= DB::table('orders')
            ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
            ->where('platforms.name', 'chowdeck')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->get('orders.platform_id')->count();
    
            $glovoOrderCount= DB::table('orders')
            ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
            ->where('platforms.name', 'glovo')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->get('orders.platform_id')->count();
    
            $edenOrderCount= DB::table('orders')
            ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
            ->where('platforms.name', 'edenlife')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->get('orders.platform_id')->count();

            $manoOrderCount= DB::table('orders')
            ->join('platforms', 'platforms.id', '=', 'orders.platform_id')
            ->where('platforms.name', 'mano')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->get('orders.platform_id')->count();
    
            $platformOrders = DB::table('orders')
            ->join('platforms', 'platforms.id', '=', 'orders.platform_id')->distinct()
            ->where('platforms.deleted_at', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->get(['platforms.*']);
            
            // pie chart
            if($countAllOrder < 1){
                $chowdeckSalesPercentageChart = $chowdeckOrderCount / 1 * 100;
                $glovoSalesPercentageChart = $glovoOrderCount / 1 * 100;
                $edenSalesPercentageChart = $edenOrderCount / 1 * 100;
                $manoSalesPercentageChart =  $manoOrderCount / 1 * 100;
            }
            else{
                $chowdeckSalesPercentageChart = $chowdeckOrderCount / $countAllOrder * 100;
                $glovoSalesPercentageChart = $glovoOrderCount / $countAllOrder * 100;
                $edenSalesPercentageChart = $edenOrderCount / $countAllOrder * 100;
                $manoSalesPercentageChart = $manoOrderCount / $countAllOrder  * 100;
            }
    
            $piechartData = [            
            'label' => ['Chowdeck', 'Glovo', 'Eden', 'Mano'],
            'data' => [round($chowdeckSalesPercentageChart) , round($glovoSalesPercentageChart),  round($edenSalesPercentageChart), round($manoSalesPercentageChart)] ,
            ];

        //sales for barchart
        $chowdeckOrder =  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(orders.order_amount) as sales'),
            )
            ->where('platforms.name', 'chowdeck')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
        $barChartChowdeckSales = Arr::pluck($chowdeckOrder, 'sales');
    
        $glovoOrder = Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(orders.order_amount) as sales'),
            )
            ->where('platforms.name', 'glovo')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
            $barChartGlovoSales = Arr::pluck($glovoOrder, 'sales');
    
        $edenOrder=  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
        ->select(
            \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
            \DB::raw('SUM(orders.order_amount) as sales'),
            )
            ->where('platforms.name', 'edenlife')
            ->where('orders.deleted_at', null)
            ->where('orders.order_amount', '!=', null)
            ->where('orders.order_ref', '!=', null)
            ->whereDate('delivery_date', '>=', $startDate)                                 
            ->whereDate('delivery_date', '<=', $endDate) 
            ->groupby('month')
            ->orderBy('month', 'asc')
            ->get();
            $barChartEdenSales = Arr::pluck($edenOrder, 'sales');

        $manoOrder=  Orders::join('platforms', 'platforms.id', '=', 'orders.platform_id')
            ->select(
                \DB::raw('DATE_FORMAT(orders.delivery_date,"%m/%Y") as month'),
                \DB::raw('SUM(orders.order_amount) as sales'),
                )
                ->where('platforms.name', 'mano')
                ->where('orders.deleted_at', null)
                ->where('orders.order_amount', '!=', null)
                ->where('orders.order_ref', '!=', null)
                ->whereDate('delivery_date', '>=', $startDate)                                 
                ->whereDate('delivery_date', '<=', $endDate) 
                ->groupby('month')
                ->orderBy('month', 'asc')
                ->get();
        $barChartManoSales = Arr::pluck($manoOrder, 'sales');
      
        $barChartData = [
            'months'        =>  $chartSalesMonth,
            'chocdekSales'  =>  $barChartChowdeckSales,
            'glovoSales'    =>  $barChartGlovoSales,
            'edenSales'     =>  $barChartEdenSales,
            'manoSales'     => $barChartManoSales,
        ]; 
        
            return view('admin.filter-dashboard', compact('name', 'role', 'countVendor',
             'countActiveVendor', 'countPlatforms', 'activePlatform',
            'countPlatforms',  'payouts', 'commission',   'sumAllOrders', 
            'countAllOrder', 'countPlatformWhereOrderCame',
            'countAllPlate', 'commissionPaid', 'data', 'salesYear', 'platformOrders',
            'chowdeckOrderCount','glovoOrderCount', 'edenOrderCount', 
            'chowdeckSalesPercentageChart', 'glovoSalesPercentageChart', 
            'edenSalesPercentageChart', 'piechartData' ,  'barChartData',
            'startDate', 'endDate',  'sumGlovoComm', 'vendorFoodPrice',
            'manoOrderCount', 'manoSalesPercentageChart'));
          
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


        $activeManoVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.vendor_status', 'active')
        ->where('sales_platform.platform_name', 'mano')
        ->get('sales_platform.vendor_id');

        $manoVendor = DB::table('sales_platform')
        ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')
        ->join('platforms', 'platforms.name', '=', 'sales_platform.platform_name')
        ->where('sales_platform.platform_name', 'mano')
        ->get('sales_platform.vendor_id');

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $platform = DB::table('platforms')
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
                'activePlatform', 'countPlatforms', 'activeManoVendor',
                'manoVendor'))->withDetails( $pagination );     
            } 
        else{return redirect()->back()->with('platform-status', 'No record order found'); }

        return view('admin.all-platform', compact('perPage', 'name', 
        'role', 'platform',  'activeChowdeckVendor', 'chowdeckVendor',
        'glovoVendor', 'activeGlovoVendor',   'activeEdenlifeVendor', 
        'edenlifeVendor', 'activePlatform', 'countPlatforms', 'activeManoVendor',
        'manoVendor'));
    }

    public function approveVendor(Request $request, $vendor_id){

        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        $vendorName = Vendor::where('id', $vendor_id)->get()->pluck('vendor_name')->first();

        $updateVendor=  Vendor::where('id', $vendor_id)->update([
            'vendor_status'     =>  'approved',
        ]);
         
        if($updateVendor){
          return  redirect('all-vendor')->with('update-vendor',    $vendorName. ' Approved successfully');
        }
        else{
          return  redirect()->back('update-error', 'Opps! something happen');
        }
    }

    public function suspendVendor(Request $request, $vendor_id){

        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $vendorName = Vendor::where('id', $vendor_id)->get()->pluck('vendor_name')->first();

        $updateVendor=  Vendor::where('id', $vendor_id)->update([
            'vendor_status'     =>  'suspended',
        ]);
         
        if($updateVendor){
          return  redirect('all-vendor')->with('update-vendor', $vendorName. ' has been suspended successfully');
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
        $addUser->fullname          = $request->name;
        $addUser->email             = $request->email;
        $addUser->role_id           = $request->role;
        $addUser->email_verified_at = $verified;
        $addUser->password          = $password;
        $addUser->status            ='active';
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
        ->leftjoin('vendor', 'vendor.id', '=', 'users.vendor')
        ->where('users.deleted_at', null)
        ->where('users.email_verified_at', '!=', null)
        ->where('users.role_id', '!=', '1')
        //->where('users.role_id', '!=', '2')//except any admin user
        ->where('users.role_id', '!=', $role)//except self
        ->where('users.id', '!=', $id)//except self
        ->select(['users.*', 'role.role_name', 'vendor.vendor_name' ])
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
        
        $vendor = Vendor::all();
        $vendor_id      = $request->vendor;
        $startDate      =  date("Y-m-d", strtotime($request->from)) ;
        $endDate        =  date("Y-m-d", strtotime($request->to));

        $sumAllOrders = Orders::where('deleted_at', null)
        ->where('order_amount', '!=', null)
        ->where('order_ref', '!=', null)
        ->where('food_price', '!=', null)
        //->whereNotNull('food_price')  
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
        ->where('orders.vendor_id', $vendor_id)
        ->whereDate('orders.delivery_date', '>=', $startDate)                                 
        ->whereDate('orders.delivery_date', '<=', $endDate) 
        ->select(['orders.*', 'vendor.vendor_name', 'platforms.name', 'users.fullname'])
        ->orderBy('orders.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor.vendor_name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.invoice_ref', 'LIKE', '%'.$search.'%')
               ->orWhere('platforms.name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.delivery_date', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.created_at', 'LIKE', '%'.$search.'%')
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
        ->update(array('deleted_at' => $today));

        if($order){
            $data = [
                'status' => true,
                'message'=> 'Invoice Number ' .$id.' deleted successfully'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice',  $data['message']);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something went wrong'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice-status', 'Opps! something went wrong'); 
        }
    }

    public function markInvoicePaid(Request $request, $invoice_ref){
        $vendor = $request->vendor_id;
        $today = Carbon::now();
        $paid =  DB::table('orders')
            ->where('orders.vendor_id', $vendor)
            ->where('orders.invoice_ref', $invoice_ref)
            ->where('orders.payment_status', '!=', null)// use this to get paid unique inv
            ->update([
            'payment_status'     => 'paid',
            'payment_date'       =>  $today ,
            'payment_remark'     =>  $request->remark 
            ]);
        if($paid){
              // use this to count all paid inv
              Orders::where('invoice_ref', $invoice_ref)
              ->where('vendor_id', $vendor)
               ->update([ 
              'order_status' => 'paid'
              ]);
            $data = [
                'status' => true,
                'message'=> 'Invoice Number' .$invoice_ref.' paid successfully'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something went wrong'
            ];
            return response()->json($data);
        }
    }
  

    public function assignVendorToUser(Request $request, $uid){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

       $user = User::where('id', $uid)
       ->get('*')->pluck('fullname')->first();

       $userRole = DB::table('role')->select('role_name')
       ->join('users', 'users.role_id', 'role.id')
       ->where('users.id', $uid)
       ->pluck('role_name')->first();
       $vendor = Vendor::all();

       return view('admin.assign-vendor-to-user', compact('role', 'user', 'userRole',
        'uid', 'vendor'));

    }

    public function storeAsignVendor(Request $request){
        $this->validate($request, [ 
            'vendor'  => 'required|max:255'      
        ]);

        $userName = User::where('id', $request->user)
        ->get('*')->pluck('fullname')->first();

        $vendor = Vendor::where('id', $request->vendor)
        ->get('*')->pluck('vendor_name')->first();

        $updateUser = User::where('id', $request->user)
        ->update([
            'vendor'    => $request->vendor
        ]);

        if($updateUser){
            return redirect('all-staff')->with('staff-assign',' ' .$userName. ' successfully assigned to ' .$vendor );
        }
        else{
            return redirect('all-staff')->with('staff-status', 'Opps! something went wrong' ); 
        }
    }
    //view expeses list per vendor
    public function expensesList(Request $request){
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        $vendor = Vendor::all();

        $vendor_id      =  $request->vendor_id;
        $startDate      =   date("Y-m-d", strtotime($request->from)) ;
        $endDate        =  date("Y-m-d", strtotime($request->to));
        
        $vendorName = Vendor::where('id', $vendor_id)
        ->get()->pluck('vendor_name')->first();
        
        $vendorExpense = VendorExpenses::where('vendor_id',  $vendor_id)
        ->whereDate('vendor_expenses.expense_date', '>=', $startDate)                                 
        ->whereDate('vendor_expenses.expense_date', '<=', $endDate) 
        ->get(['vendor_expenses.*']);

        $vendorTotalExpense = VendorExpenses::where('vendor_id',  $vendor_id)
        ->whereDate('expense_date', '>=', $startDate)                                 
        ->whereDate('expense_date', '<=', $endDate) 
        ->sum('cost');

        return view('admin.expenses-list', compact('role', 'vendor',
        'vendorExpense', 'vendorTotalExpense', 'vendorName', 'startDate', 'endDate'));
    }

    // page to add more expenses to the list
    public function newExpenses(Request $request){
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        $vendor = Vendor::all();
        return view('admin.new-expenses', compact('role', 'vendor'));
    }

    public function addExpenses(Request $request){
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
            return redirect()->back()->with('expense-status', 'Expense added successfully');
        }
        else{
            return redirect()->back()->with('expense-error', 'Opps! something went wrong');
        }
        return view('admin.new-expenses', compact('role', 'vendor'));
    }


    public function importExpensesList(Request $request)
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
      $import =  Excel::import(new ImportExpensesList($vendor_id), $file);

      if($import){
        return redirect()->back()->with('expense-status', 'File imported successfully!');
      }
      else{
        return redirect()->back()->with('expense-error', 'Opps!');
      } 
    }

        //view sales list per vendor
        public function salesList(Request $request){
            $id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
            $vendor = Vendor::all();
            $vendor_id      =  $request->vendor_id;
            $startDate      =   date("Y-m-d", strtotime($request->from)) ;
            $endDate        =  date("Y-m-d", strtotime($request->to));
 
            $vendorName = Vendor::where('id', $vendor_id)
            ->get()->pluck('vendor_name')->first();
            
            $vendorSales = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->get(['*']);
    
            $vendorTotalSales = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->sum('price');

            $totalSoup = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->sum('soup_total');

            $totalSwallow = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->sum('swallow_total');

            $totalProtein = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->sum('protein_total');

            $totalOthers = OfflineSales::where('vendor_id',  $vendor_id)
            ->whereDate('sales_date', '>=', $startDate)                                 
            ->whereDate('sales_date', '<=', $endDate) 
            ->sum('others_total');
        
            $total =  $vendorTotalSales + $totalSoup + $totalSwallow + $totalProtein + $totalOthers ;

            return view('admin.vendor-sales-list', compact('role', 'vendor',
            'vendorSales', 'vendorTotalSales', 'vendorName',
            'startDate', 'endDate',  'vendorSales', 'vendorTotalSales', 'total'));
        }

        public function newOfflineFoodMenu(Request $request){
            $id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
            $vendor = Vendor::all();
            return view('admin.new-offline-foodmenu', compact('role', 'vendor'));
        }
    
        public function addOfflineFoodMenu(Request $request){
            $this->validate($request, [ 
                'vendor'  => 'required|max:255',
                'item'   => 'required|string|max:255'      
            ]);
    
            $storeMenu = new OfflineFoodMenu();
            $storeMenu->vendor_id    = $request->vendor;
            $storeMenu->item         = $request->item;
            $storeMenu->added_by     = Auth::user()->id;
            $storeMenu->save();
    
            if($storeMenu){
                return redirect()->back()->with('expense-status', 'Food menu added successfully');
            }
            else{
                return redirect()->back()->with('expense-error', 'Opps! something went wrong');
            }
            return view('admin.new-offile-foodmenu', compact('role', 'vendor'));
        }
    
    
        public function importOfflineFoodMenu(Request $request)
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
          $import =  Excel::import(new ImportOfflineFoodMenu($vendor_id), $file);
    
          if($import){
            return redirect()->back()->with('expense-status', 'File imported successfully!');
          }
          else{
            return redirect()->back()->with('expense-error', 'Opps!');
          } 
        }

    public function profitAndLoss(Request $request){
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();
        $vendor = Vendor::all();

        $today = Carbon::now()->format('Y-m-d');
        $lastSevenDays = Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d');

        $vendor_id      = $request->vendor_id;
        $startDate      =   date("Y-m-d", strtotime($request->from)) ;
        $endDate        =  date("Y-m-d", strtotime($request->to));

        $vendorName = Vendor::where('id', $vendor_id)
        ->get()->pluck('vendor_name')->first();

        $vendorTotalExpense = VendorExpenses::where('vendor_id',  $vendor_id)
        ->whereDate('expense_date', '>=', $startDate)                                 
        ->whereDate('expense_date', '<=', $endDate) 
        ->sum('cost');

        $vendorTotalSales = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('price');

        $totalSoup = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('soup_total');

        $totalSwallow = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('swallow_total');

        $totalProtein = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('protein_total');

        $totalOthers = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('others_total');
    
        $total =  $vendorTotalSales + $totalSoup + $totalSwallow + $totalProtein + $totalOthers ;
        $profitAndLoss = $total - $vendorTotalExpense;

        $soupSold = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('soup_qty');

        $swallowSold = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('swallow_qty');

        $proteinSold = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('protein_qty');

        $othersSold = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->sum('others_qty');

        $totalItemSold =   $soupSold + $swallowSold + $proteinSold + $othersSold ;

        $plateOfSoup = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->where('soup', '!=', null)
        ->get('soup')->pluck('soup');
        
        $plateOfRice = OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->where('others', '!=', null)
        ->where('others', 'rice')
        ->count();

       $quantityOfRiceSold =  OfflineSales::where('vendor_id',  $vendor_id)
        ->whereDate('sales_date', '>=', $startDate)                                 
        ->whereDate('sales_date', '<=', $endDate) 
        ->where('others', '!=', null)
        ->where('others', 'rice')
        ->sum('others_qty');

        //$stringSoup =  $plateOfSoup;
        $soupString = 'plate';
        $countPlateOfSoup = substr_count($plateOfSoup, $soupString);
        $countAllPlates = $soupSold + $quantityOfRiceSold;

        return view('admin.profit-and-loss', compact('role', 'vendor',
       'vendorTotalExpense', 'vendorTotalSales', 'profitAndLoss', 
        'vendorName', 'startDate', 'endDate', 'total', 
        'totalItemSold', 'countAllPlates'));
    }

    public function vendorInvoiceCommisionPaid(Request $request){

        $commission     = $request->commission_paid;
        $order_id       = $request->order_id;

         $updateOrder = Orders::where('id', $order_id)
         ->update([
             'commission'     => $commission,
         ]);
         if($updateOrder){
            $data = [
                'status' => true,
                'message'=> 'Record updated successfully'
            ];
            return response()->json($data);
        }
         else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something happen'
            ];
            return response()->json($data);
         }
     }

     public function showDeletedInvoice(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');


        $orders = DB::table('orders')->distinct()
        ->join('merge_invoices', 'orders.number_of_order_merge', '=', 'merge_invoices.number_of_order_merge')
        ->join('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->where('orders.deleted_at', '!=', null)
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
                return view('admin.restore-invoices',  compact(
                'perPage', 'name', 'role', 'orders'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('invoice-status', 'No record order found');}
        return view('admin.restore-invoices', compact('name', 'role', 'orders'));
     }

     public function restoreDeletedInvoice(Request $request, $invoice_ref){
        $today = Carbon::now();
        $vendor_id = $request->vendor_id;
 
        $order = DB::table('orders')
        ->where('invoice_ref', '=', $invoice_ref)
        ->update(array('deleted_at' => null));

        if($order){
            $data = [
                'status' => true,
                'message'=> 'Invoice Number' .$invoice_ref.' restored successfully. Check merge invoices'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice',  $data['message']);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something went wrong'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice',  $data['message']);
        }
    }

    public function allDeletedRows(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search'); 

        $orders = DB::table('orders')
        ->join('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->join('users', 'orders.added_by', '=', 'users.id')
        ->Join('platforms', 'orders.platform_id', '=', 'platforms.id')
        ->where('orders.deleted_at', '!=', null)
        ->where('orders.order_amount', '!=', null)
        ->where('orders.order_ref', '!=', null)
        ->select(['orders.*', 'vendor.vendor_name', 'platforms.name', 'users.fullname'])
        ->orderBy('orders.created_at', 'desc')
        ->where(function ($query) use ($search) {  // <<<
        $query->where('vendor.vendor_name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.invoice_ref', 'LIKE', '%'.$search.'%')
               ->orWhere('platforms.name', 'LIKE', '%'.$search.'%')
               ->orWhere('orders.delivery_date', 'LIKE', '%'.$search.'%')
               ->orderBy('orders.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'orders'
        )->appends(['per_page'   => $perPage]);
    
        $pagination = $orders->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.deleted-row',  compact(
                'perPage', 'name', 'role', 'orders'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('order-status', 'No record order found');}
        return view('admin.deleted-row', compact('name', 'role', 'orders'));
    }

    public function restoreDeletedRow(Request $request, $id){
        $today = Carbon::now();
 
        $order = DB::table('orders')
        ->where('id', '=', $id)
        ->update(array('deleted_at' => null));

        if($order){
            $data = [
                'status' => true,
                'message'=> 'Order restored successfully. Check merge invoices'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice',  $data['message']);
        }
        else{
            $data = [
                'status' => false,
                'message'=> 'Opps! something went wrong'
            ];
            //return response()->json($data);
            return redirect()->back()->with('invoice',  $data['message']);
        }
    }

    public function editUser(Request $request, $id){
        if( Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $user = User::find($id);
            $userRole = Role::where('id', '!=', '1')
            ->where('id', '!=', '2')
            ->get();
            //->where('role.id', '!=', '2')//except admin

            $staffRoleName = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
       
            $getVendorID = User::where('id', $id)
           ->get('vendor')->toArray();
    
            $vendorID_list = array_column($getVendorID, 'vendor'); 
            $selectMultipleVendor= call_user_func_array('array_merge', $vendorID_list);
            $multipleVendor_list = Vendor::whereIn('id', $selectMultipleVendor)
            // ->groupBy('id')
            ->get()->pluck('vendor_name');
            //dd( $data_list );

            $removeBracket = substr($multipleVendor_list, 1, -1);
            $staffVendorAssignedTo =  str_replace('"', ' ', $removeBracket);

            $vendor = Vendor::all();
      
            return view('admin.edit-user-role', compact('userRole', 'user', 
            'role', 'name', 'staffRoleName', 'vendor', 'staffVendorAssignedTo')); 
        }
          else { return Redirect::to('/login');
        }
  }

    public function updateUser(Request $request, $id)
    {
        $this->validate($request, [
            'fullname'      => 'required|max:255',
            'email'         => 'required|max:255',
            'role'          => 'required|max:255',
            'vendor'        => 'required|max:255',
            ]);

            // $role = $request->role;
            // $vendor = $request->vendor;
            if($request->role){
                //
                $role = $request->role;
            }
            else{
                $role = $request->old_role;
            }

            if($request->vendor){
                //
                $vendor = $request->vendor;
            }
            else{
                $vendor =  $request->old_vendor;
              
            }
           // dd($request->vendor);
            $user = User::find($id);
            $user->fullname         = $request->fullname;
            $user->email            = $request->email;
            $user->role_id          = $role ;
            $user->vendor           = $vendor;
            $user->update();

            if($user){
                return redirect()->back()->with('update-user', 'Record Updated');
  
            }
            else{
                return redirect()->back()->with('update-error', 'Opps! something went wrong'); 
            }
    }

    public function exportOfflineFoodMenuTemplate(Request $request){
       
        return Excel::download(new ExportOfflineFoodMenu(), 'offline-foodmenu-template.xlsx');
    }

    public function activateUser(Request $request)
    {
        $today= date("Y-m-d", strtotime(Carbon::now()));
       if($request->status == 'inactive'){
        $user = User::find($request->user_id);
        User::where('id', $request->user_id)
        ->update([
            'status'        =>'inactive',
            'deleted_at'    =>$today
        ]);
        // $user->status = 'inactive';
        // $user->deleted_at = $today;
        // $user->save();
       }
       if($request->status == 'active'){
        $user = User::find($request->user_id);
        User::withTrashed()->find($request->user_id)->restore([
            'deleted_at'  => null
          ]);
          User::where('id', $request->user_id)
          ->update([
              'status'        =>'active',
          ]);

       }

        return response()->json([
            'success'=>$request->status.'Status change successfully.', 
            'status'=>$request->status 
    ]);
    }


    public function userRolePage(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $allRoles = DB::table('role')
        ->where('role_name', '!=',  'superadmin')// except superadmin
        ->orderBy('role.created_at', 'desc')
        ->select(['role.*' ])
        ->where(function ($query) use ($search) {  // <<<
        $query->where('role.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('role.role_name', 'LIKE', '%'.$search.'%')
               ->orderBy('role.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'role'
        )->appends(['per_page'   => $perPage]);
        $pagination = $allRoles->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.role',  compact(
                'perPage', 'name', 'role', 'allRoles'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('status', 'No record order found');}
        return view('admin.role', compact('name', 'role', 'allRoles'));
    }


    public function addRole(Request $request){
        $this->validate($request, [ 
            'role'   => 'required|string|max:255',
        ]);

        $addRole = new Role;
        $addRole->role_name = $request->role;
        $addRole->save();
        
        if($addRole){
           return redirect()->back()->with('add-role', 'New Role Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }


    public function multiStoreAddRole(Request $request){
        $this->validate($request, [ 
            'role'   => 'required|string|max:255',
        ]);

        $addRole = new MultiStoreRole;
        $addRole->role_name = $request->role;
        $addRole->multi_store_id = $request->store_id;
        $addRole->save();
        
        if($addRole){
           return redirect()->back()->with('add-role', 'New Role Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function multiStoreRolePage(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $vendors = MultiStore::all();

        $perPage = $request->perPage ?? 25;
        $search = $request->input('search');

        $allRoles = DB::table('multi_store_role')
        ->join('multi_store', 'multi_store.id', 'multi_store_role.multi_store_id')
        //->join('vendor', 'vendor.id', 'multi_store.vendor_id')
        ->orderBy('multi_store_role.created_at', 'desc')
        ->select(['multi_store_role.*', ])
        ->where(function ($query) use ($search) {  // <<<
        $query->where('multi_store_role.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('multi_store_role.role', 'LIKE', '%'.$search.'%')
            //    ->orWhere('vendor.store_name', 'LIKE', '%'.$search.'%')
               ->orderBy('multi_store_role.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'role'
        )->appends(['per_page'   => $perPage]);
        $pagination = $allRoles->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('multistore.multistore-roles',  compact(
                'perPage', 'name', 'role', 'allRoles', 'vendors'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('status', 'No record order found');}
        return view('multistore.multistore-roles', compact('name', 'role', 'allRoles', 'vendors'));
    }


    public function storeLocation(Request $request){
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $user_id)
        ->pluck('role_name')->first();

        $state = State::all();

        $perPage = $request->perPage ?? 10;
        $search = $request->input('search');

        $location = DB::table('area')
        ->join('state', 'state.id', 'area.state_id')
        ->orderBy('area.created_at', 'desc')
        ->select(['area.*' , 'state.state'])
        ->where(function ($query) use ($search) {  // <<<
        $query->where('area.created_at', 'LIKE', '%'.$search.'%')
               ->orWhere('area.area', 'LIKE', '%'.$search.'%')
               ->orWhere('state.state', 'LIKE', '%'.$search.'%')
               ->orderBy('area.created_at', 'desc');
        })->paginate($perPage, $columns = ['*'], $pageName = 'area'
        )->appends(['per_page'   => $perPage]);
        $pagination = $location->appends ( array ('search' => $search) );
            if (count ( $pagination ) > 0){
                return view('admin.store-location',  compact(
                'perPage', 'name', 'role', 'location', 'state'))->withDetails( $pagination );     
            } 
            else{return redirect()->back()->with('status', 'No record order found');}
        return view('admin.store-location', compact('name', 'role', 'location', 'state'));
    }


    public function addLocation(Request $request){
        $this->validate($request, [ 
            'location'   => 'required|string|max:255',
            'state'      => 'required|max:255',
        ]);

        $area = new Area;
        $area->area         = $request->location;
        $area->state_id     = $request->state;
        $area->save();
        
        if($area){
           return redirect()->back()->with('add-role', 'New Location Added!');
        }
        else{return redirect()->back()->with('error', 'Opps! something went wrong.'); }
    }

    public function newParentVendor(Request $request){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $stateID = DB::table('state')->select(['*'])
        ->pluck('id');

        $state = State::all();
        $location = Area::all();
        $countryID = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('id')->first();

        $country = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('country')->first();

        $selectBankName = BankList::all();
        $selectFoodType = FoodType::all();
        $selectRestaurantType = RestaurantType::all();

        return view('multistore.add-new-parent', compact('name', 
        'role', 'state', 'country', 'selectBankName',
        'selectFoodType', 'selectRestaurantType', 'stateID', 'countryID', 'location'));
    }

    public function addParentVendor(Request $request){
        if(Auth::user()){
        //parentvendor
            $name = Auth::user()->name;
            $id = Auth::user()->id;
            // generate a pin based on 2 * 5 digits + a random character
            $pin = mt_rand(100000, 999999);
            // shuffle pin
            $vendorRef = 'V'.str_shuffle($pin); 
            $this->validate($request, [ 
                'logo'                     => 'image|mimes:jpg,png,jpeg|max:300',
                'store_name'               => 'required|string|max:255',
                'area'                      => 'required|string|max:255',
                'state'                     => 'required|string|max:255',
                'number_of_store_location'  => 'required|string|max:255',
                'first_name'                => 'required|string|max:255',
                'last_name'                 => 'required|string|max:255',
                'phone'                     => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:13',
                'email'                     => 'required|email|max:255', 
                'address'                   => 'required|string|max:255', 
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

            $role = Role::where('role_name', 'parentvendor')
            ->get()->pluck('id')->first();

            $username = substr($request->store_name, -10);

            $addUser = new User;
            $addUser->username          = $username;
            $addUser->fullname          = $request->first_name. ' ' .$request->last_name;
            $addUser->email             = $request->email;
            $addUser->role_id           = $role;
            $addUser->email_verified_at = $verified;
            $addUser->password          = $password;
            $addUser->status            ='active';
            $addUser->save();

            $foodType = $request->food_type;
           
            if($addUser){
            $vendorStatus                           = 'pending';
            $vendorName                             = $request->area. '-' .$foodType;
            //this works on local host and linux
            //$path = $request->file('image')->store('/images/resource', ['disk' =>   'my_files']);  
            $logo= $request->file('logo');
            if(isset($logo)){
                 $logoName =  rand(1000000000, 9999999999).'.jpeg';
                 $logo->move(public_path('assets/images/store'),$logoName);
                 $logoPath = "/assets/images/store/".$logoName; 
             }
            else {
             $logoPath = "";
             }

            $addVendor                              = new Vendor();
            $addVendor->vendor_ref                  = $vendorRef;
            $addVendor->added_by                    = $id;
            $addVendor->vendor_logo                  = $logoPath;
            $addVendor->store_name                  = $request->store_name;
            $addVendor->store_area                  = $request->area;
            $addVendor->vendor_name                 = $request->store_name;
            $addVendor->number_of_store_locations   = $request->number_of_store_location;
            $addVendor->description                 = $request->description;
            $addVendor->contact_fname               = $request->first_name;
            $addVendor->contact_lname               = $request->last_name;
            $addVendor->contact_phone               = $request->phone;
            $addVendor->email                       = $request->email;
            $addVendor->address                     = $request->address;
            $addVendor->state_id                    = $request->state;
            $addVendor->country_id                  = $request->country;
            $addVendor->vendor_status               = $vendorStatus;
            $addVendor->save();

              $parentStore = new MultiStore();
              $parentStore->vendor_id        = $addVendor->id;
              $parentStore->user_id          = $addUser->id;
              $parentStore->multi_store_name = $addVendor->store_name;
              $parentStore->level            = 'parent';
              $parentStore->save();
              User::where('id', $addUser->id)->update(['parent_store' => $parentStore->id]);
                
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

                $data = array(
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $tempoaryPassword, 
                'url'      =>'https://pos.localeats.africa',
                );
                //dd($data);
                Mail::to($request->email)
                ->cc('admin@localeats.africa')
                //->bcc('admin@localeats.africa')
                ->send(new NewVendorEmail($data));

                $response = [
                    'code'      => '',
                    'message'   => 'Parent Vendor added successfully',
                    'status'    => 'success',
                ];
                $data = json_encode($response, true);

                return redirect()->back()->with('add-vendor', 'Parent Vendor: ' .$request->store_name. '  successfully added');
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

    public function allParentVendor(Request $request){
        if(Auth::user()){
            $name = Auth::user()->name;
            $id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->pluck('role_name')->first();
    
            $countVendor =  DB::table('multi_store')
            ->join('vendor', 'vendor.id', 'multi_store.vendor_id')
            ->where('multi_store.level', 'parent')
            ->get();

             // a vendor is consider active if it's active on one or more platform
            $countActivevendor = DB::table('sales_platform')
            ->join('vendor', 'vendor.id', '=', 'sales_platform.vendor_id')->distinct()
            ->join('multi_store', 'multi_store.vendor_id', 'vendor.id')
            ->where('sales_platform.vendor_status', 'active')
            ->get('sales_platform.vendor_id');
       
            $perPage = $request->perPage ?? 25;
            $search = $request->input('search');
    
            $vendor =  DB::table('vendor')
            ->join('multi_store', 'multi_store.vendor_id', 'vendor.id')
            ->join('state', 'state.id', '=', 'vendor.state_id')
            ->where('multi_store.level', 'parent')
            ->select(['multi_store.*', 'vendor.vendor_status', 'vendor.store_area',
            'state.state'])
            ->orderBy('vendor.created_at', 'desc')
            ->where(function ($query) use ($search) {  // <<<
            $query->where('multi_store.multi_store_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('vendor.vendor_status', 'LIKE', '%'.$search.'%');
            })
            ->paginate($perPage,  $pageName = 'vendor')->appends(['per_page'   => $perPage]);
            $pagination = $vendor->appends ( array ('search' => $search) );
                if (count ( $pagination ) > 0){
                    return view('multistore.parent-vendor',  compact(
                    'perPage', 'name', 'role', 'vendor', 'countVendor',
                    'countActivevendor'))->withDetails( $pagination );     
                } 
            else{ 
                //return  redirect()->back()->with('vendor-status', 'No record order found');
                return view('multistore.parent-vendor',  compact('perPage' , 'name', 'role', 
                'vendor', 'countVendor', 'countActivevendor')); 
                }

            return view('multistore.parent-vendor',  compact('perPage' , 'name', 'role', 
            'vendor', 'countVendor', 'countActivevendor'));
        }
    }

    public function childVendor(Request $request, $vendor_id){
        if(Auth::user()){
            $name = Auth::user()->name;
            $user_id = Auth::user()->id;
            $role = DB::table('role')->select('role_name')
            ->join('users', 'users.role_id', 'role.id')
            ->where('users.id', $user_id)
            ->pluck('role_name')->first();

            $vendorName = DB::table('vendor')->where('id', $vendor_id)
            ->select('*')->pluck('store_name')->first();

            $parent = DB::table('multi_store')
            ->where('vendor_id', $vendor_id)
            ->get('*')->pluck('id')->first();
  //dd( $parent);
            $countVendor =  DB::table('vendor')
            ->join('sub_store', 'sub_store.vendor_id', 'vendor.id')
            ->where('sub_store.multi_store_id', $parent)
            ->get();
             // a vendor is consider active if it's active on one or more platform
            $countActivevendor = DB::table('sales_platform')
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
            ->select(['sub_store.*', 'vendor.vendor_status', 'vendor.store_area',
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
                    return view('multistore.child-vendor',  compact(
                    'perPage', 'childVendor', 'role', 'vendorName', 
                    'countVendor', 'countActivevendor'))->withDetails($pagination);     
                } 
            else{ 
                // Session::flash('food-status', 'No record order found'); 
                return view('multistore.child-vendor',  compact('perPage', 
                'childVendor', 'role', 'vendorName', 'countVendor', 'countActivevendor'))->with('food-status', 'No record order found'); }
            
                return view('multistore.child-vendor',  compact('perPage', 
                'childVendor', 'role', 'vendorName', 'countVendor', 'countActivevendor'));
        }
    }

    public function newChildVendor(Request $request, $vendor_id){
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $role = DB::table('role')->select('role_name')
        ->join('users', 'users.role_id', 'role.id')
        ->where('users.id', $id)
        ->pluck('role_name')->first();

        $vendorName = DB::table('vendor')->where('id', $vendor_id)
        ->select('*')->pluck('store_name')->first();

        $parent_id = DB::table('multi_store')
        ->where('vendor_id', $vendor_id)
        ->get('*')->pluck('id')->first();

        $stateID = DB::table('state')->select(['*'])
        ->pluck('id');

        $state = State::all();
        $location = Area::all();
        $countryID = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('id')->first();

        $country = DB::table('country')->select('*')
        ->where('country', 'Nigeria')
        ->pluck('country')->first();

        $selectBankName = BankList::all();
        $selectFoodType = FoodType::all();
        $selectRestaurantType = RestaurantType::all();
        return view('multistore.add-new-child-vendor', compact('name','role', 'state', 
        'country', 'selectBankName', 'selectFoodType', 'selectRestaurantType', 
        'stateID', 'countryID', 'location', 'vendorName', 'parent_id'));  
    }

    public function storeChildVendor(Request $request){
            //child vendor
            $name = Auth::user()->name;
            $id = Auth::user()->id;

            $parent = DB::table('multi_store')
            ->where('vendor_id', $request->parent_id)
            ->get('*')->pluck('id')->first();

            $pin = mt_rand(100000, 999999);
            // shuffle pin
            $vendorRef = 'V'.str_shuffle($pin); 
            $this->validate($request, [ 
            'store_name'               => 'required|string|max:255',
            'area'                      => 'required|string|max:255',
            'state'                     => 'required|string|max:255',
            'restaurant_type'           => 'required|string|max:255',
            'food_type'                 => 'required|max:255',
            'number_of_store_location'  => 'required|string|max:255',
            'delivery_time'             => 'max:255',
            'first_name'                => 'required|string|max:255',
            'last_name'                 => 'required|string|max:255',
            'phone'                     => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:13',
            'email'                     => 'required|email|max:255', 
            'address'                   => 'required|string|max:255', 
            'bankName'                  => 'string|max:255', 
             'accountNumber'             => 'max:255', 
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
            $role = Role::where('role_name', 'childvendor')
            ->get()->pluck('id')->first();
            $username = substr($request->store_name, -30);
        
            $addUser = new User;
            $addUser->username          = $username;
            $addUser->fullname          = $request->first_name. ' ' .$request->last_name;
            $addUser->email             = $request->email;
            $addUser->role_id           = $role;
            $addUser->email_verified_at = $verified;
            $addUser->password          = $password;
            $addUser->status            ='active';
            $addUser->save();
        
            $foodType = $request->food_type;
            if($addUser){
                $vendorStatus                           = 'pending';
                $vendorName                             = $request->area. '-' .$foodType;
                $addVendor                              = new Vendor();
                $addVendor->vendor_ref                  = $vendorRef;
                $addVendor->added_by                    = $id;
                $addVendor->store_name                  = $request->store_name;
                $addVendor->store_area                  = $request->area;
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
        
                $childStore = new SubStore();
                $childStore->vendor_id        = $addVendor->id;
                $childStore->user_id          = $addUser->id;
                $childStore->multi_store_id   = $request->parent_id;
                $childStore->level            = 'child';
                $childStore->save();

                User::where('id', $addUser->id)
                ->update([
                    'vendor' => $addVendor->id,
                    'parent_store' => $request->parent_id
                ]);
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
        
                $data = array(
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $tempoaryPassword,   
                'url'      =>'https://pos.localeats.africa',     
                );
                Mail::to($request->email)
                ->cc('admin@localeats.africa')
                //->bcc('admin@localeats.africa')
                ->send(new NewVendorEmail($data));
        
                $response = [
                    'code'      => '',
                    'message'   => 'Vendor successfully added ',
                    'status'    => 'success',
                ];
                 $data = json_encode($response, true);
        
                return redirect()->back()->with('add-vendor', 'New outlet: ' .$request->store_name. ' successfully added  ');
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
            return redirect()->back()->with('add-vendor', 'Something went wrong');
        

    }


}//class