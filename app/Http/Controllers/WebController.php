<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class WebController extends Controller
{

    public function index(){
        return view('index');
    }

    public function success(){
        return view('success');
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function payment(Request $request){
        // Set your Merchant Server Key
        $option = $request->get('option');

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('environment') == "production";
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
                    'price' => '100',
                    'quantity' => 1,
                    'name' => 'PhotoBooth'
                ]
            ),
            'customer_details' => array(
                'first_name' => $this->generateRandomString(10),
                'last_name' => '',
                'email' => 'on.blurred@gmail.com',
                'phone' => '',
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('index', ['snap_token'=>$snapToken , 'option' => $option]);


    }

    public function payment_post(Request $request){
        // return $request;
        $json = json_decode($request->get('json'));
        $order = new Order();
        $order->status = $json->transaction_status;
        $order->uname = $json->transaction_id;
        $order->email = 'on.blurred@gmail.com';
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->fraud_status) ? $json->fraud_status : null;
        $order->pdf_url = isset($json->finish_redirect_url) ? $json->finish_redirect_url : null;
        if($order->save()) { 
            $node_url =  env('NODE_URL');
            $dslr_url = env('DSLR_URL');
            Http::get($dslr_url.'/api/start?mode=print&password=pD3VOy2FfIgwyQ3Z');
            Http::get($node_url.'/close');
            redirect(url('/success'))->with('alert-success', 'Transaksi berhasil');
        }else{ 
            redirect(url('/'))->with('alert-failed', 'Transaksi gagal!!');
        }   
    }
}
