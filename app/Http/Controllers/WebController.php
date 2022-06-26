<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class WebController extends Controller
{

    public function index(){
        return view('index');
    }


    public function payment(Request $request){
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'item_details' => array(
                [
                    'id' => 'a1',
                    'price' => '30000',
                    'quantity' => 1,
                    'name' => 'PhotoBooth'
                ]
            ),
            'customer_details' => array(
                'first_name' => $request->get('uname'),
                'last_name' => '',
                'email' => $request->get('email'),
                'phone' => '',
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('payment', ['snap_token'=>$snapToken]);


    }

    public function payment_post(Request $request){
        // return $request;
        $json = json_decode($request->get('json'));
        $order = new Order();
        $order->status = $json->transaction_status;
        $order->uname = $request->get('uname');
        $order->email = $request->get('email');
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->fraud_status) ? $json->fraud_status : null;
        $order->pdf_url = isset($json->finish_redirect_url) ? $json->finish_redirect_url : null;
        return $order->save() ? redirect(url('/'))->with('alert-success', 'Transaksi berhasil') : redirect(url('/'))->with('alert-failed', 'Transaksi gagal!!');
    }
}
