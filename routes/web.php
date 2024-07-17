<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorManagerController;
use App\Http\Controllers\TwitterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();
 //Clear route cache
 Route::get('/route-clear', function() {
    \Artisan::call('route:clear');
    return 'Routes cache cleared';
});

//Clear config cache
Route::get('/config-clear', function() {
    \Artisan::call('config:clear');
    return 'Config cache cleared';
}); 

// Clear application cache
Route::get('/cache-clear', function() {
    \Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache
Route::get('/view-clear', function() {
    \Artisan::call('view:clear');
    return 'View cache cleared';
});

// Clear cache using reoptimized class
Route::get('/optimize-clear', function() {
    \Artisan::call('optimize:clear');
    return 'View cache cleared';
});

Route::group(['middleware' => ['auth']], function() {
    Route::post('logout', [App\Http\Controllers\Auth\LogoutController::class,'logout'])->name('logout');
    Route::get('show-change-password',[App\Http\Controllers\HomeController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('change-password',[App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');

});

Route::webhooks('paystack/webhook', 'paystack-webhook');
Route::webhooks('chowdeck/webhook', 'chowdeck-webhook');
//https://office.localeats.africa/auth/twitter/callback

Route::controller(TwitterController::class)->group(function(){
    Route::get('auth/twitter', 'redirectToTwitter')->name('auth.twitter');
    Route::get('auth/twitter/callback', 'handleTwitterCallback');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('new-vendor',  'newVendor')->name('new-vendor');
    Route::post('add-vendor',  'addVendor')->name('add-vendor');
    Route::get('all-vendor',  'allVendor')->name('all-vendor');
    Route::get('vendor-profile/{id}',  'vendorProfile')->name('vendor-profile');
    Route::get('food-menu',  'foodMenu')->name('food-menu');
    Route::get('all-food-menu',  'allFoodMenu')->name('all-food-menu');
    Route::get('edit-food-menu/{id}', 'editFoodMenu')->name('edit-food-menu');
    Route::post('update-food-menu/{id}',  'updateFoodMenu')->name('update-food-menu');
    Route::post('delete-food-menu/{id}', 'deleteFoodMenu')->name('delete-food-menu');
    Route::post('add-food-menu',  'addFoodMenu')->name('add-food-menu');
    Route::get('show-change-password', 'showChangePassword')->name('show-change-password');
    Route::post('import-food-menu', 'importFoodMenu')->name('import-food-menu');
    Route::get('setup-vendor',  'setupApprovedVendor')->name('setup-vendor');
    Route::post('setup',  'setup')->name('setup');
    Route::get('create-invoice',  'createInvoice')->name('create-invoice');
    Route::get('upload-invoice/{id}',  'uploadInvoice')->name('upload-invoice');
    Route::post('add-invoice',  'storeInvoice')->name('add-invoice');
    Route::post('merge-invoice',  'mergeInvoice')->name('merge-invoice'); 
    Route::get('computed-invoice/{id}/{number_of_import}/{ref}',  'showMergeInvoices')->name('computed-invoice');
    Route::post('update-merge-invoice-food',  'updateMergeInvoiceFood')->name('update-merge-invoice-food'); 
    Route::post('update-merge-invoice-extra',  'updateMergeInvoiceExtra')->name('update-merge-invoice-extra'); 
    Route::get('vendor-merged-invoices',  'vendorMergedInvoices')->name('vendor-merged-invoices'); 
    Route::post('update-merge-invoice-payout',  'updateVendorInvoicePayout')->name('update-merge-invoice-payout');     
    Route::post('generate-invoice',  'generateInvoice')->name('generate-invoice');     
    Route::get('invoice/{id}/{vendor}',  'showInvoice')->name('invoice'); 
    Route::get('all-invoices',  'showAllFinalInvoices')->name('all-invoices'); 
    Route::get('edit-vendor/{id}',  'editVendor')->name('edit-vendor');
    Route::post('update-vendor/{id}',  'updateVendor')->name('update-vendor');
    Route::post('delete-order/{id}',  'deleteOrder')->name('delete-order');
    Route::post('reset-order-food-price/{id}',  'resetOrderFoodPrice')->name('reset-order-food-price');
    Route::post('reset-order-extra/{id}',  'resetOrderExtra')->name('reset-order-extra');
    //exportinvoice
    Route::post('export-invoice/{id}', 'exportInvoice')->name('export-invoice');
    Route::get('email-invoice/{id}', 'emailPdfInvoice')->name('email-invoice');
    Route::post('send-email-pdf/{id}', 'sendEmailPdfInvoice')->name('send-email-pdf');

   
});

Route::controller(SuperAdminController::class)->group(function () {
    Route::get('superadmin',  'index')->name('superadmin');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('admin',  'index')->name('admin');
    Route::post('approve-vendor/{id}',  'approveVendor')->name('approve-vendor');
    Route::get('new-platform',  'newPlatform')->name('new-platform');
    Route::post('add-platform',  'addPlatform')->name('add-platform');
    Route::get('all-platform',  'allPlatform')->name('all-platform');
    Route::get('restaurant',  'restaurant')->name('restaurant');
    Route::post('add-restaurant',  'addRestaurant')->name('add-restaurant');
    Route::get('food-type',  'foodType')->name('food-type');
    Route::post('add-food-type',  'addFoodType')->name('add-food-type');
    Route::get('new-staff',  'newUser')->name('new-staff');
    Route::post('add-user',  'adduser')->name('add-user');
    Route::get('all-staff',  'allUser')->name('all-staff');
    Route::post('vendor-platform-ref/{id}',  'updateVendorPlatformRef')->name('vendor-platform-ref');
    Route::get('all-orders',  'allOrders')->name('all-orders');
   
});

Route::controller(ManagerController::class)->group(function () {
    Route::get('manager',  'index')->name('manager');
});

Route::controller(FinanceController::class)->group(function () {
    Route::get('finance',  'index')->name('finance'); 
});

Route::controller(AuditorController::class)->group(function () {
    Route::get('auditor',  'index')->name('auditor'); 
});

Route::controller(VendorManagerController::class)->group(function () {
    Route::get('vendormanager',  'index')->name('vendor_manager');

});
// Route::get('create-invoice', function () {
//     return view('upload-order');
// });