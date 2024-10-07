<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CompanyDetailsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;

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

// Change language
Route::get('lang/{local}', [DashboardController::class, 'change'])->name('changeLang');

// Auth Routes
Route::get('/',[AuthController::class,'showLoginForm']);
Route::post('login',[AuthController::class,'login'])->name('login');
Route::post('logout',[AuthController::class,'logout'])->name('logout');
Route::get('signup-form',[AuthController::class,'showSignupForm']);
Route::post('signup',[AuthController::class,'signup']);
Route::get('reset-password',[AuthController::class,'resetPassword']);
Route::post('forget-password',[AuthController::class,'forgetPassword']);
Route::get('view-update-password/{token}/{email}',[AuthController::class,'viewUpdatePassword']);
Route::post('update-password',[AuthController::class,'updatePassword']);
Route::get('verify-account/{token}/{email}',[AuthController::class,'verifyAccount']);


Route::middleware('sentinel.auth')->group(function () {

    // Admin Dashboard Routes
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('structure-datevalue',[DashboardController::class,'structureDateFilter'])->name('structure-datevalue');
    Route::post('payment-overview-chart',[DashboardController::class,'paymentOverviewChart'])->name('payment-overview-chart');
    Route::post('overview-dropdown-filter',[DashboardController::class,'overviewDropdownFilter'])->name('overview-dropdown-filter');
    Route::post('payment-activity-chart',[DashboardController::class,'paymentActivityChart'])->name('payment-activity-chart');
    

    // Client Dashboard Routes
    Route::get('client-dashboard',[DashboardController::class,'clientDashboard'])->name('client-dashboard');

    // Invoice Routes
    Route::get('invoice-list',[InvoiceController::class,'invoiceList'])->name('invoice-list');
    Route::get('client-invoice-list',[InvoiceController::class,'clientInvoiceList'])->name('client-invoice-list');
    Route::get('add-invoice-view',[InvoiceController::class,'addInvoiceView'])->name('add-invoice-view');
    Route::get('make-invoice/{id?}',[InvoiceController::class,'addInvoiceView'])->name('make-invoice');
    Route::post('add-invoice',[InvoiceController::class,'addInvoice'])->name('add-invoice');
    Route::get('view-invoice/{id}',[InvoiceController::class,'viewInvoice'])->name('view-invoice');
    Route::get('edit-invoice/{id}',[InvoiceController::class,'editInvoice'])->name('edit-invoice');
    Route::post('update-invoice',[InvoiceController::class,'updateInvoice'])->name('update-invoice');
    Route::get('delete-invoice/{id}',[InvoiceController::class,'deleteInvoice'])->name('delete-invoice');
    Route::post('get-description',[InvoiceController::class,'getDescription'])->name('get-description');
    Route::get('download-invoice/{id}',[InvoiceController::class,'downloadInvoice'])->name('download-invoice');

    // Payment Routes
    Route::get('payment-list',[PaymentController::class,'paymentList'])->name('payment-list');
    Route::get('paid-payment',[PaymentController::class,'paidPayment'])->name('paid-payment');
    Route::get('pending-payment',[PaymentController::class,'pendingPayment'])->name('pending-payment');
    Route::get('refunded-payment',[PaymentController::class,'refundedPayment'])->name('refunded-payment');
    Route::get('cancel-payment',[PaymentController::class,'cancelPayment'])->name('cancel-payment');
    Route::get('refund-payment/{id}',[PaymentController::class,'refundPayment'])->name('refund-payment');

    // Client Payment Routes (Stripe PaymentGateway)
    Route::post('make-invoice-payment/{id}',[PaymentController::class,'makeInvoicePayment'])->name('make-invoice-payment');
    Route::get('stripe-success',[PaymentController::class,'paymentSuccess'])->name('stripe-success');

    // Tax Routes
    Route::get('tax-list',[TaxController::class,'taxList'])->name('tax-list');
    Route::post('add-tax',[TaxController::class,'addTax'])->name('add-tax');
    Route::post('update-tax',[TaxController::class,'updateTax'])->name('update-tax');
    Route::get('delete-tax/{id}',[TaxController::class,'deleteTax'])->name('delete-tax');
    Route::get('change-status/{id}',[TaxController::class,'changeTaxStatus'])->name('change-status');
    
    Route::get('discount-list',[TaxController::class,'discountList'])->name('discount-list');
    Route::post('add-discount',[TaxController::class,'addDiscount'])->name('add-discount');
    Route::post('update-discount',[TaxController::class,'updateDiscount'])->name('update-discount');
    Route::get('delete-discount/{id}',[TaxController::class,'deleteDiscount'])->name('delete-discount');
    Route::get('change-discount-status/{id}',[TaxController::class,'changeDiscountStatus'])->name('change-discount-status');

    Route::get('shipping-charge-list',[TaxController::class,'shippingChargeList'])->name('shipping-charge-list');
    Route::post('add-shipping-charge',[TaxController::class,'addShippingCharge'])->name('add-shipping-charge');
    Route::post('update-shipping-charge',[TaxController::class,'updateShippingCharge'])->name('update-shipping-charge');
    Route::get('delete-shipping-charge/{id}',[TaxController::class,'deleteShippingCharge'])->name('delete-shipping-charge');
    Route::get('change-shipping-charge-status/{id}',[TaxController::class,'changeShippingChargeStatus'])->name('change-shipping-charge-status');

    // Products Routes
    Route::get('product-list',[ProductController::class,'productList'])->name('product-list');
    Route::get('add-product-view',[ProductController::class,'addProductView'])->name('add-product-view');
    Route::post('add-product',[ProductController::class,'addProduct'])->name('add-product');
    Route::get('edit-product/{id}',[ProductController::class,'editProduct'])->name('edit-product');
    Route::post('update-product',[ProductController::class,'updateProduct'])->name('update-product');
    Route::get('delete-product/{id}',[ProductController::class,'deleteProduct'])->name('delete-product');
    Route::post('delete-sub-image',[ProductController::class,'deleteSubImage'])->name('delete-sub-image');

    // Brand Routes
    Route::get('brand-list',[ProductController::class,'brandList'])->name('brand-list');
    Route::post('add-brand',[ProductController::class,'addBrand'])->name('add-brand');
    Route::post('update-brand',[ProductController::class,'updateBrand'])->name('update-brand');
    Route::get('delete-brand/{id}',[ProductController::class,'deleteBrand'])->name('delete-brand');

    // Category Routes
    Route::get('category-list',[ProductController::class,'categoryList'])->name('category-list');
    Route::post('add-category',[ProductController::class,'addCategory'])->name('add-category');
    Route::post('update-category',[ProductController::class,'updateCategory'])->name('update-category');
    Route::get('delete-category/{id}',[ProductController::class,'deleteCategory'])->name('delete-category');

    // Color Routes
    Route::get('color-list',[ProductController::class,'colorList'])->name('color-list');
    Route::post('add-color',[ProductController::class,'addColor'])->name('add-color');
    Route::post('update-color',[ProductController::class,'updateColor'])->name('update-color');
    Route::get('delete-color/{id}',[ProductController::class,'deleteColor'])->name('delete-color');

    // Report Routes
    Route::get('product-list',[ProductController::class,'productList'])->name('product-list');
    Route::get('add-product',[ProductController::class,'addProduct'])->name('add-product-get');

    // Report Routes
    Route::get('sale-reports',[ReportController::class,'saleReports'])->name('sale-reports');

    // Client Routes
    Route::get('client-list',[ClientController::class,'clientList'])->name('client-list');
    Route::post('add-client',[ClientController::class,'addClient'])->name('add-client');
    Route::post('update-client',[ClientController::class,'updateClient'])->name('update-client');
    Route::get('change-client-status/{id}',[ClientController::class,'changeClientStatus'])->name('change-client-status');
    Route::get('delete-client/{id}',[ClientController::class,'deleteClient'])->name('delete-client');

    // Accountant Routes
    Route::get('accountant-list',[AccountantController::class,'accountantList'])->name('accountant-list');
    Route::post('add-accountant',[AccountantController::class,'addAccountant'])->name('add-accountant');
    Route::post('update-accountant',[AccountantController::class,'updateAccountant'])->name('update-accountant');
    Route::get('change-accountant-status/{id}',[AccountantController::class,'changeAccountantStatus'])->name('change-accountant-status');
    Route::get('delete-accountant/{id}',[AccountantController::class,'deleteAccountant'])->name('delete-accountant');

    // Company Details Routes
    Route::get('company-list',[CompanyDetailsController::class,'companyList'])->name('company-list');
    Route::post('add-company',[CompanyDetailsController::class,'addCompany'])->name('add-company');
    Route::post('update-company',[CompanyDetailsController::class,'updateCompany'])->name('update-company');
    Route::get('change-company-status/{id}',[CompanyDetailsController::class,'changeCompanyStatus'])->name('change-company-status');
    Route::get('delete-company/{id}',[CompanyDetailsController::class,'deleteCompany'])->name('delete-company');

    // Profile Routes
    Route::get('view-profile',[ProfileController::class,'viewProfile'])->name('view-profile');
    Route::post('update-profile',[ProfileController::class,'updateProfile'])->name('update-profile');
    Route::post('update-password',[ProfileController::class,'updatePassword'])->name('update-password');

    // Setting Routes
    Route::get('view-site-settings',[SettingController::class,'viewSiteSetting'])->name('view-site-settings');
    Route::post('update-site-setting',[SettingController::class,'updateSiteSetting'])->name('update-site-setting');
    
    // Notification routes
    Route::get('notification-list', [NotificationController::class,'notificationList'])->name('notification-list');
});
