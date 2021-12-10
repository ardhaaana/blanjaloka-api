<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Support\Str;
use Exception;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Transaction;

class TransaksiController extends Controller
{

    public function __construct(){

        $this->middleware('auth');

        Veritrans_Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Veritrans_Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Veritrans_Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Veritrans_Config::$is3ds = env('MIDTRANS_IS3DS');
    
    }

    public function getsnaptoken(Request $request){

        $this->validate($request, [
            'produk*' => 'required',
            'pajak' => 'required|numeric',
            'total_pembayaran' => 'required|numeric'
        ]);

        $list_produk = $request->input('produk');

        for($i=0; $i<count($list_produk); $i++){

            if(count(Produk::where('id_produk', $list_produk[$i]['id'])->get()) == 0){

                return response()->json([
                    'success' => 0,
                    'message' => 'id produk tidak ditemukan',
                    'id_produk' => $list_produk[$i]['id']
                ]);
    
            }

        }

        # PUSH ARRAY PAJAK
        $pajak = [
            "id"=>rand(0, 50),
            "quantity"=>1,
            "price"=> $request->input('pajak'),
            "name"=> "Pajak Negara"
        ];

        array_push($list_produk, $pajak);

        $order_id = Str::random(30);

//         # ALAMAT KANTOR CITIASIA
//         $billing_address = array(
//             'first_name'    => "Blanjaloka",
//             'last_name'     => "Citiasia",
//             'address'       => "Jln Mangga Gang Senggol Jakarta",
//             'city'          => "Jakarta",
//             'postal_code'   => "16602",
//             'phone'         => "081122334455",
//             'country_code'  => 'IDN'
//         );


        foreach (Customer::where('id_customer', $request->session()->get('id_customer'))->get() as $c){

            $customer_details = array(
                'first_name'    => $c->nama_customer,
                'email'         => $c->email_customer
            );
            
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $request->input('total_pembayaran')
            ],
            'item_details'=>$list_produk,
            'customer_details' => $customer_details
//             'billing_address' => $billing_address
        ];

        try{

            $snap_token = Veritrans_Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snap_token,
                'redirect_url' => 'https://app.sandbox.veritrans.co.id/snap/v2/vtweb/'.$snap_token
            ]);

        }catch(Exception $e){

            return [
                'error_message' => $e->getMessage()
            ];

        }
 
    }


    public function getStatusTransaksi($order_id){
        $status = Veritrans_Transaction::status($order_id);
        return response()->json($status);
    }
   
    public function batalkanTransaksi($order_id){
        $status = Veritrans_Transaction::cancel($order_id);
        return response()->json($status);
    }

}
