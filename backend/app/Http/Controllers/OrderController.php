<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'products' => $request->products,
            'total_price' => $request->total_price,
            'status' => 'pending'
        ]);
        return response()->json($order, 201);
    }

    public function getOrders()
    {
        return response()->json(Order::where('user_id', auth()->id())->get());
    }
}
