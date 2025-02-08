<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Supplier routes
Route::middleware(['auth', 'role:supplier'])->group(function () {
    Route::get('/supplier/home', [SupplierController::class, 'index'])->name('supplier.home');
    Route::get('/supplier/manage-products', [SupplierController::class, 'manageProducts'])->name('supplier.manage-product');
    Route::post('/supplier/manage-products/store', [SupplierController::class,'store'])->name('supplier.manage-product.store');
    Route::get('/supplier/manage-products/{productID}/edit', [SupplierController::class,'edit'])->name('supplier.manage-product.edit');
    Route::put('/supplier/manage-products/{productID}/update', [SupplierController::class, 'update'])->name('supplier.manage-product.update');
    Route::delete('/supplier/manage-products/{productID}/delete', [SupplierController::class, 'destroy'])->name('supplier.manage-product.destory');
});

// Retailer routes
Route::middleware(['auth', 'role:retailer'])->group(function () {
    Route::get('/retailer/home', [RetailerController::class, 'index'])->name('retailer.home');
    Route::get('/retailer/manage-products', [RetailerController::class, 'manageProducts'])->name('retailer.manage-product');

    Route::get('/retailer/supplier/home', [SupplierController::class, 'index'])->name('retailer.supplierhome');

    Route::get('/retailer/orders',[OrderController::class, 'index'])->name('retailer.orders');
    Route::post('/retailer/manage-products', [OrderController::class, 'store'])->name('retailer.orders.store');
    Route::post('/retailer/manage-products/store', [RetailerController::class,'store'])->name('retailer.manage-product.store');
    Route::get('/retailer/manage-products/{productID}/edit', [RetailerController::class,'edit'])->name('retailer.manage-product.edit');
    Route::put('/retailer/manage-products/{productID}/update', [RetailerController::class,'update'])->name('retailer.manage-product.update');
    Route::get('/retailer/manage-products/{productID}/destroy', [RetailerController::class,'destroy'])->name('retailer.manage-product.destroy');
});

// Reseller routes
Route::middleware(['auth', 'role:reseller'])->group(function () {
    Route::get('/reseller/home', [ResellerController::class, 'index'])->name('reseller.home');
    Route::get('/reseller/manage-products', [ResellerController::class, 'manageProducts'])->name('reseller.manage-product');

    Route::get('/reseller/supplier/home', [SupplierController::class, 'index'])->name('retailer.supplierhome');
    Route::get('/reseller/retailer/home', [RetailerController::class, 'index'])->name('reseller.retailerhome');

    Route::get('/reseller/orders',[OrderController::class, 'index'])->name('reseller.orders');
    Route::post('/reseller/manage-products', [OrderController::class, 'store'])->name('reseller.orders.store');
    Route::post('/reseller/manage-products/store', [ResellerController::class,'store'])->name('reseller.manage-product.store');
    Route::get('/reseller/manage-products/{productID}/edit', [ResellerController::class,'edit'])->name('reseller.manage-product.edit');
    Route::put('/reseller/manage-products/{productID}/update', [ResellerController::class,'update'])->name('reseller.manage-product.update');
    Route::get('/reseller/manage-products/{productID}/destroy', [ResellerController::class,'destroy'])->name('reseller.manage-product.destroy');
});
