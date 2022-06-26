<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class ApiController extends Controller
{
    public function payment_handler(Request $request){
        $json = json_decode($request->getContent());
        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));
        
        if($signature_key != $json->signature_key){
            return abort(404);
        }

        // status berhasil
        $order = Order::where('order_id', $json->order_id)->first();
        return $order->update(['status'=>$json->transaction_status]);
    }

    public function webhook(Request $request){
        $event_type = $request->get('event_type');
        Log::debug($request->get('event_type'));
        if ($event_type == "session_end"){
            $node_url =  env('NODE_URL');
            Http::get($node_url.'/start');
        }
        return true;
    }
}
