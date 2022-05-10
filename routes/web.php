<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/category/{id}', [SiteController::class, 'category'])->name('site.category');
Route::get('/product/{id}', [SiteController::class, 'product'])->name('site.product');
