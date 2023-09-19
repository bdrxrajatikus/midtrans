<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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
                'gross_amount' =>  $request->price,
            ),
            'item_details' => array(
                [
                    'id' => 'a1',
                    'price' => $request->price,
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

        return view('payment', ['snap_token'=>$snapToken , 'option' => $option]);

    }

    public function payment_test(Request $request){
        $price = $request->price;
        $promo_code = $request->promo_code;
        var_dump($promo_code);
    }


    public function payment_post(Request $request){
        // return $request;
        Log::info('Nilai Request: ' . json_encode($request->all()));
        $json = json_decode($request->get('json'));
        /*$order->status = $json->transaction_status;
        $order->uname = $json->transaction_id;
        $order->email = 'on.blurred@gmail.com';
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->fraud_status) ? $json->fraud_status : null;
        $order->pdf_url = isset($json->finish_redirect_url) ? $json->finish_redirect_url : null;*/

        $transactionApi = env('API_URL') . '/transactions'; 
        $response = Http::post($transactionApi, [
            'transaction_date' => now()->toDateTimeString(),
            'phone_number' => '-',
            'price' => $request->masterPrice,
            'promo_code_id' => $request->promoId != "null" ? $request->promoId : null, 
            'final_price' =>  $json->gross_amount, 
            'status' => $json->transaction_status
        ]);
        if($json->transaction_status == "settlement") { 
            $node_url =  env('NODE_URL');
            $dslr_url = env('DSLR_URL');
            //Http::get($dslr_url.'/api/start?mode=print&password=VrSkxBCqo9WGeDR2');
            //Http::get($node_url.'/close');
            return redirect(url('/success'))->with('alert-success', 'Transaksi berhasil');
        }else{ 
            return redirect('/')->with('alert-failed', 'Transaksi gagal!!');
        }   
    }
}
