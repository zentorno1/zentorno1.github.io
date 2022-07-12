<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Model\BusinessSetting;
use App\Model\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;

class StripePaymentController extends Controller
{

    public function payment_process_3d()
    {
        $tran = Str::random(6) . '-' . rand(1, 1000);
        $order_id = session('order_id');
        session()->put('transaction_ref', $tran);
        $order = Order::with(['details'])->where(['id' => $order_id])->first();
        $config = Helpers::get_business_settings('stripe');
        Stripe::setApiKey($config['api_key']);
        header('Content-Type: application/json');

        $YOUR_DOMAIN = url('/');

        $products = [];
        foreach ($order->details as $detail) {
            array_push($products, [
                'name' => $detail->product['name'] ?? "",
                'image' => 'def.png'
            ]);
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => Helpers::currency_code(),
                    'unit_amount' => $order->order_amount * 100,
                    'product_data' => [
                        'name' => BusinessSetting::where(['key' => 'restaurant_name'])->first()->value,
                        'images' => [asset('storage/app/public/restaurant') . '/' . \App\CentralLogics\Helpers::get_business_settings('logo')],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/pay-stripe/success',
            'cancel_url' => url()->previous(),
        ]);

        return response()->json(['id' => $checkout_session->id]);
    }

    public function success()
    {
        DB::table('orders')
            ->where('id', session('order_id'))
            ->update(['order_status' => 'confirmed', 'transaction_reference' => session('transaction_ref'), 'payment_method' => 'stripe', 'payment_status' => 'paid']);

        $order = Order::find(session('order_id'));
        if ($order->callback != null) {
            return redirect($order->callback . '/success');
        } else {
            return \redirect()->route('payment-success');
        }
    }

    public function fail()
    {
        $order = Order::find(session('order_id'));
        if ($order->callback != null) {
            return redirect($order->callback . '/fail');
        } else {
            return \redirect()->route('payment-fail');
        }
    }
}
