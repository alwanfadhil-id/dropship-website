<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id()],
            ['products' => $request->products]
        );
        return response()->json($cart);
    }

    public function getCart()
    {
        return response()->json(Cart::where('user_id', auth()->id())->first());
    }

    public function removeFromCart($productId)
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $cart->products = array_filter($cart->products, fn($p) => $p['id'] !== $productId);
        $cart->save();
        return response()->json($cart);
    }
}
