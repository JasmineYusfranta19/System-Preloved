<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Order;
use App\Models\Payment;

class PaymentCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        // Cari order berdasarkan order_number
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Cari payment berdasarkan order_id
        $payment = Payment::where('order_id', $order->id)->first();
        if (!$payment) {
             return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->update(['status' => 'pending']);
                } else {
                    $payment->update(['status' => 'paid', 'payment_method' => $type]);
                    $order->update(['status' => 'processing']); // ubah status order
                }
            }
        } elseif ($transaction == 'settlement') {
            $payment->update(['status' => 'paid', 'payment_method' => $type]);
            $order->update(['status' => 'processing']);
        } elseif ($transaction == 'pending') {
            $payment->update(['status' => 'pending']);
        } elseif ($transaction == 'deny') {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'cancelled']);
        } elseif ($transaction == 'expire') {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'cancelled']);
        } elseif ($transaction == 'cancel') {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }
}
