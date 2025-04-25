<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\IncidentTempController;
use App\Http\Controllers\AssetManagementController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\OrganizationController;

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


Route::get('/', function () {
    return view('layouts.landing');
});

// User (Fanny)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

});

Route::middleware('auth')->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('userManagements/create', [UserController::class, 'create'])->name('userManagements.create');
        Route::post('userManagements', [UserController::class, 'store'])->name('userManagements.store');
        Route::get('userManagements/{id}/edit', [UserController::class, 'edit'])->name('userManagements.edit');
        Route::patch('userManagements/{id}', [UserController::class, 'update'])->name('userManagements.update');
        Route::delete('userManagements/{id}', [UserController::class, 'destroy'])->name('userManagements.destroy');

        Route::patch('/leaveTypes/{leaveType}/approve', [LeaveTypeController::class, 'approve'])->name('leaveTypes.approve');
    });

    Route::get('userManagements', [UserController::class, 'index'])->name('userManagements.index');
    Route::get('userManagements/create', [UserController::class, 'create'])->name('userManagements.create');
    Route::post('userManagements', [UserController::class, 'store'])->name('userManagements.store');
    Route::get('userManagements/{id}/edit', [UserController::class, 'edit'])->name('userManagements.edit');
    Route::patch('userManagements/{id}', [UserController::class, 'update'])->name('userManagements.update');
    Route::delete('userManagements/{id}', [UserController::class, 'destroy'])->name('userManagements.destroy');

    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    //leaveType (Wildan)
    Route::resource('/leaveTypes', LeaveTypeController::class);

    Route::get('/getdepartments/{organization}', [UserController::class, 'getDepartments']);

    //Ticketing (Hanif)
    Route::resource('/tickets', TicketController::class);
    Route::post('/tickets/{id}/createMessage', [TicketController::class, 'createMessage'])->name('tickets.createMessage');
    Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::patch('/tickets/{ticket}/reopen', [TicketController::class, 'reopen'])->name('tickets.reopen');
    Route::patch('/tickets/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.comment');

    //Temporary Incidents (Hanif)
    Route::get('/incidentTemps', [IncidentTempController::class, 'index'])->name('incidentTemps.index');
    Route::get('/incidentTemps/create', [IncidentTempController::class, 'create'])->name('incidentTemps.create');
    Route::post('/incidentTemps', [IncidentTempController::class, 'store'])->name('incidentTemps.store');
    Route::delete('/incidentTemps/{incidentTemp}', [IncidentTempController::class, 'destroy'])->name('incidentTemps.destroy');
    Route::post('/incidentTemps/{incidentTemp}', [IncidentTempController::class, 'storeToIncidents'])->name('incidentTemps.storeToIncidents');

    // Asset (Zaim)
    Route::get('/assetManagement', [AssetManagementController::class, 'index'])->name('assetManagement.index');

    Route::get('/productTypes', [ProductTypeController::class, 'index'])->name('productTypes.index');
    Route::get('/createproductTypes', [ProductTypeController::class, 'create'])->name('productTypes.create');
    Route::post('/storeproductTypes', [ProductTypeController::class, 'store'])->name('productTypes.store');
    Route::get('/showproductTypes/{id}', [ProductTypeController::class, 'show'])->name('productTypes.show');
    Route::get('/editproductTypes/{id}', [ProductTypeController::class, 'edit'])->name('productTypes.edit');
    Route::put('/updateproductTypes/{id}', [ProductTypeController::class, 'update'])->name('productTypes.update');
    Route::get('/deleteproductTypes/{id}', [ProductTypeController::class, 'delete'])->name('productTypes.delete');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/createproducts', [ProductController::class, 'create'])->name('products.create');
    Route::post('/storeproducts', [ProductController::class, 'store'])->name('products.store');
    Route::get('/getProductTypesByOrganization', [ProductController::class, 'getProductTypesByOrganization'])->name('getProductTypesByOrganization');
    Route::get('/showproducts/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/editproducts/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/updateproducts/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/deleteproducts/{id}', [ProductController::class, 'delete'])->name('products.delete');


    Route::resource('services', ServicesController::class);
    Route::resource('incidents', IncidentController::class);


    Route::resource('organizations', OrganizationController::class);
    Route::resource('departments', DepartmentController::class);

    //service (Dinda)
    Route::resource('services', ServicesController::class);



});



