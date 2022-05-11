<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required'
        ]);

        $prdoduct = Product::findOrFail($request->product_id);

        if($prdoduct->sale_price) {
            $price = $prdoduct->sale_price;
        }else {
            $price = $prdoduct->price;
        }

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if($cart) {
            $cart->update([
                'qty' => $cart->qty + $request->qty
            ]);
        }else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'price' => $price,
                'qty' => $request->qty
            ]);
        }

        $prdoduct->update(['quantity' => ($prdoduct->quantity - $request->qty)]);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function remove_cart($id)
    {
        $cart = Cart::findOrFail($id);

        $prdoduct = $cart->product;

        $prdoduct->update(['quantity' => ($prdoduct->quantity + $cart->qty)]);

        $cart->delete();

        return redirect()->back();
    }
}
