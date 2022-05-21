<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApiController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

});

// Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
Route::prefix(LaravelLocalization::setLocale())->group(function() {

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/', [SiteController::class, 'index'])->name('site.index');
    Route::get('/shop', [SiteController::class, 'shop'])->name('site.shop');
    Route::get('/category/{id}', [SiteController::class, 'category'])->name('site.category');
    Route::get('/product/{id}', [SiteController::class, 'product'])->name('site.product');
    Route::post('/add_review', [SiteController::class, 'add_review'])->name('site.add_review');


    // Cart Operation Routes
    Route::middleware('auth')->group(function() {
        Route::post('add-to-cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');
        Route::get('remove-cart/{id}', [CartController::class, 'remove_cart'])->name('remove_cart');
        Route::get('cart', [CartController::class, 'cart'])->name('cart');
        Route::post('update-cart', [CartController::class, 'update_cart'])->name('update_cart');
        Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::get('checkout/thanks', [CartController::class, 'checkout_thanks'])->name('checkout_thanks');
    });

    Route::get('posts-api', [ApiController::class, 'index']);

});
