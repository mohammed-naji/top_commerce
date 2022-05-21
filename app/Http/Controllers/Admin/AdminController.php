<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $ccount = Category::count();
        $pcount = Product::count();
        $ocount = Order::sum('total');
        $ucount = User::count();
        return view('admin.index', compact('ccount', 'pcount', 'ocount', 'ucount'));
    }
}
