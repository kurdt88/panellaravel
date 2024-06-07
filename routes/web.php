<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RescissionController;
use App\Http\Controllers\SubpropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/', [HomeController::class, 'welcome']);
    Route::get('/dashboard', [HomeController::class, 'welcome']);



    //RUTAS para el permiso CREATE
    Route::group(['middleware' => ['can:create']], function () {
        Route::get('/newproperty', [PropertyController::class, 'create']);
        Route::get('/newlease', [LeaseController::class, 'create']);
        Route::get('/newtenant', [TenantController::class, 'create']);
        Route::get('/newpayment', [PaymentController::class, 'create']);
        Route::get('/newinvoice', [InvoiceController::class, 'create']);
        Route::get('/newexpense', [ExpenseController::class, 'create']);
        Route::get('/newbuilding', [BuildingController::class, 'create']);
        Route::get('/newsubproperty', [SubpropertyController::class, 'create']);
        Route::get('/newlandlord', [LandlordController::class, 'create']);
        Route::get('/newaccount', [AccountController::class, 'create']);
        Route::get('/newsupplier', [SupplierController::class, 'create']);
        Route::get('/newbudget/{building}', [BuildingController::class, 'createBudget']);


        Route::post('/cancellease', [RescissionController::class, 'store']);
        Route::post('/indexproperties', [PropertyController::class, 'store']);
        Route::post('/indexleases', [LeaseController::class, 'store']);
        Route::post('/indextenants', [TenantController::class, 'store']);
        Route::post('/indexpayments', [PaymentController::class, 'store']);
        Route::post('/indexinvoices', [InvoiceController::class, 'store']);
        Route::post('/indexexpenses', [ExpenseController::class, 'store']);
        Route::post('/indexbuildings', [BuildingController::class, 'store']);
        Route::post('/indexsubproperties', [SubpropertyController::class, 'store']);
        Route::post('/indexlandlords', [LandlordController::class, 'store']);
        Route::post('/indexaccounts', [AccountController::class, 'store']);
        Route::post('/indexsuppliers', [SupplierController::class, 'store']);
        Route::post('/indexbudgets', [BudgetController::class, 'store']);

        Route::get('/cancellease/{lease}', [LeaseController::class, 'cancel']);

        Route::get('/deleteleaseinvoices/{lease}', [LeaseController::class, 'deleteinvoices']);

        Route::post('/delleaseinvoices/{lease}', [LeaseController::class, 'delinvoices']);


        Route::get('/renewlease/{lease}', [LeaseController::class, 'renew']);

    });

    //RUTAS para el permiso MGMTUSERS
    Route::group(['middleware' => ['can:mgmtusers']], function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/indexusers/{user}/edit', [UserController::class, 'edit']);
        Route::put('/indexusers/{user}', [UserController::class, 'update']);
        Route::delete('/deluser/{user}', [UserController::class, 'destroy']);
    });

    //RUTAS para el permiso EDIT
    Route::group(['middleware' => ['can:edit']], function () {
        Route::get('/indexproperties/{property}/edit', [PropertyController::class, 'edit']);
        Route::get('/indexleases/{lease}/edit', [LeaseController::class, 'edit']);
        Route::get('/indextenants/{tenant}/edit', [TenantController::class, 'edit']);
        Route::get('/indexpayments/{payment}/edit', [PaymentController::class, 'edit']);
        Route::get('/indexinvoices/{invoice}/edit', [InvoiceController::class, 'edit']);
        Route::get('/indexexpenses/{expense}/edit', [ExpenseController::class, 'edit']);
        Route::get('/indexbuildings/{building}/edit', [BuildingController::class, 'edit']);
        Route::get('/indexsubproperties/{subproperty}/edit', [SubpropertyController::class, 'edit']);
        Route::get('/indexlandlords/{landlord}/edit', [LandlordController::class, 'edit']);
        Route::get('/indexaccounts/{account}/edit', [AccountController::class, 'edit']);
        Route::get('/indexsuppliers/{supplier}/edit', [SupplierController::class, 'edit']);
        Route::get('/indexbudgets/{budget}/edit', [BudgetController::class, 'edit']);

        Route::put('/indexproperties/{property}', [PropertyController::class, 'update']);
        Route::put('/indexleases/{lease}', [LeaseController::class, 'update']);
        Route::put('/indextenants/{tenant}', [TenantController::class, 'update']);
        Route::put('/indexpayments/{payment}', [PaymentController::class, 'update']);
        Route::put('/indexinvoices/{invoice}', [InvoiceController::class, 'update']);
        Route::put('/indexexpenses/{expense}', [ExpenseController::class, 'update']);
        Route::put('/indexbuildings/{building}', [BuildingController::class, 'update']);
        Route::put('/indexsubproperties/{subproperty}', [SubpropertyController::class, 'update']);
        Route::put('/indexlandlords/{landlord}', [LandlordController::class, 'update']);
        Route::put('/indexaccounts/{account}', [AccountController::class, 'update']);
        Route::put('/indexsuppliers/{supplier}', [SupplierController::class, 'update']);
        Route::put('/indexbudgets/{budget}', [BudgetController::class, 'update']);
    });



    //RUTAS para el permiso EDIT
    Route::group(['middleware' => ['can:delete']], function () {
        Route::delete('/deltenant/{tenant}', [TenantController::class, 'destroy']);
        Route::delete('/dellease/{lease}', [LeaseController::class, 'destroy']);
        Route::delete('/delproperty/{property}', [PropertyController::class, 'destroy']);
        Route::delete('/delpayment/{payment}', [PaymentController::class, 'destroy']);
        Route::delete('/delinvoice/{invoice}', [InvoiceController::class, 'destroy']);
        Route::delete('/delexpense/{expense}', [ExpenseController::class, 'destroy']);
        Route::delete('/delbuilding/{building}', [BuildingController::class, 'destroy']);
        Route::delete('/delsubproperty/{subproperty}', [SubpropertyController::class, 'destroy']);
        Route::delete('/dellandlord/{landlord}', [LandlordController::class, 'destroy']);
        Route::delete('/delaccount/{account}', [AccountController::class, 'destroy']);
        Route::delete('/delsupplier/{supplier}', [SupplierController::class, 'destroy']);
        Route::delete('/delbudget/{budget}', [BudgetController::class, 'destroy']);
    });

    //RUTAS para el permiso BANKACCOUNT
    Route::group(['middleware' => ['can:bankaccount']], function () {
        Route::get('/accounts', [AccountController::class, 'index']);
        Route::get('/accounts/{account}', [AccountController::class, 'show']);
        Route::get('/accountmonthmovements/{account}', [AccountController::class, 'showMonthMovements']);
        Route::get('/accountallmovements/{account}', [AccountController::class, 'showAllMovements']);
        Route::get('/accountsearchmovements/{account}', [AccountController::class, 'searchMovements']);
        Route::post('/searchmovements/{account}', [AccountController::class, 'accountsearchmovements']);
    });

    //RUTAS para el permiso VIEW
    Route::group(['middleware' => ['can:view']], function () {

        Route::get('/properties', [PropertyController::class, 'index']);
        Route::get('/leases', [LeaseController::class, 'index']);
        Route::get('/leases_valid', [LeaseController::class, 'index_valid']);

        Route::get('/leases_onrenovation', [LeaseController::class, 'index_onrenovation']);


        Route::get('/tenants', [TenantController::class, 'index']);
        Route::get('/payments', [PaymentController::class, 'index']);
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoices_active', [InvoiceController::class, 'index_active']);
        Route::get('/invoices_active_payment', [InvoiceController::class, 'index_active_payment']);
        Route::get('/invoices_active_expense', [InvoiceController::class, 'index_active_expense']);
        Route::get('/invoices_overdue', [InvoiceController::class, 'index_overdue']);
        Route::get('/expenses', [ExpenseController::class, 'index']);
        Route::get('/buildings', [BuildingController::class, 'index']);
        Route::get('/subproperties', [SubpropertyController::class, 'index']);
        Route::get('/landlords', [LandlordController::class, 'index']);
        Route::get('/suppliers', [SupplierController::class, 'index']);



        Route::get('/searchbudgetmovements/{building}', [BuildingController::class, 'searchmovements']);
        Route::post('/budgetmovements/{building}', [BuildingController::class, 'budgetsearchmovements']);


        Route::get('/propertycommodities/{property}/', [PropertyController::class, 'showCommodities']);
        Route::get('/supplierpayments/{supplier}/', [SupplierController::class, 'showPayments']);

        Route::get('/properties/{property}', [PropertyController::class, 'show']);
        Route::get('/leases/{lease}', [LeaseController::class, 'show']);
        Route::get('/tenants/{tenant}', [TenantController::class, 'show']);
        Route::get('/payments/{payment}', [PaymentController::class, 'show']);
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);
        Route::get('/expenses/{expense}', [ExpenseController::class, 'show']);
        Route::get('/buildings/{building}', [BuildingController::class, 'show']);
        Route::get('/subproperties/{subproperty}', [SubpropertyController::class, 'show']);
        Route::get('/landlords/{landlord}', [LandlordController::class, 'show']);
        Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
        Route::get('/leasemovements/{lease}', [LeaseController::class, 'showMovements']);
        Route::get('/buildingproperties/{building}', [BuildingController::class, 'showProperties']);
        Route::get('/buildingmaintenanceexpenses/{building}', [BuildingController::class, 'showMaintenanceExpenses']);
        Route::get('/buildingbudgets/{building}', [BuildingController::class, 'showBudgets']);
        Route::get('/propertysubproperties/{property}', [PropertyController::class, 'showSubproperties']);
        Route::get('/landlorditems/{landlord}', [LandlordController::class, 'showItems']);


        Route::get('/paymentpdf/{payment}', [PaymentController::class, 'getpdf']);
        Route::get('/invoicepdf/{invoice}', [InvoiceController::class, 'getpdf']);
        Route::get('/invoicexml/{invoice}', [InvoiceController::class, 'getxml']);

        Route::post('api/fetch-invoices', [DropdownController::class, 'fetchInvoice']);
        Route::post('api/fetch-subproperties', [DropdownController::class, 'fetchSubproperties']);

        Route::get('profile', [HomeController::class, 'settings']);
    });

    URL::forceScheme('https');

});
