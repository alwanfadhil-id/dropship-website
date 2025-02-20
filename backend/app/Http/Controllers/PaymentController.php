<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Ganti ke true jika live
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = uniqid(); // Buat order ID unik
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->total_price,
            ],
            'customer_details' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => $request->phone,
            ]
        ];

        // Buat Snap Token untuk pembayaran
        $snapToken = Snap::getSnapToken($params);

        // Simpan order ke database
        Order::create([
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'products' => $request->products,
            'total_price' => $request->total_price,
            'status' => 'pending'
        ]);

        return response()->json(['token' => $snapToken]);
    }

    public function handleNotification(Request $request)
    {
        $notif = json_decode($request->getContent(), true);
        $order = Order::where('order_id', $notif['order_id'])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($notif['transaction_status'] === 'settlement') {
            $order->update(['status' => 'paid']);
        } elseif ($notif['transaction_status'] === 'expire') {
            $order->update(['status' => 'expired']);
        } elseif ($notif['transaction_status'] === 'cancel') {
            $order->update(['status' => 'canceled']);
        }

        return response()->json(['message' => 'Notification processed']);
    }
}
