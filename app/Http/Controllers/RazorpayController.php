<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    // public function showPaymentPage(Request $request)
    // {
    //     // return inertia('');
    // }

    public function make_payment(Request $request)
    {
        $amount = $request->amount;
        $name = $request->name;

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $payment = Payment::create([
            'name' => $name,
            'amount' => $amount,
            // 'payment_id' => $orderId,
        ]);

        $order = $api->order->create(
            [
                'receipt' => $payment->id,
                'amount' => $amount * 100,
                'currency' => 'INR'
            ]
        );

        $orderId = $order['id'];
        $payment->payment_id = $orderId;
        $payment->save();

        return [
            'order_id' => $orderId,
            'amount' => $amount,
            'key' => config('services.razorpay.key'),
        ];
    }

    public function hook(Request $request)
    {
        // return [$request->razorpay_payment_id, $request->razorpay_order_id] ;

        $payment = Payment::where('payment_id', $request->razorpay_order_id)->first();

        $payment->razorpay_id = $request->razorpay_payment_id ;

        $payment->payment_done = $request->razorpay_payment_id ? true : false;
        
        $payment->save();

    }
}
