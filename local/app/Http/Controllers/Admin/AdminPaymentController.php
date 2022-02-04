<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPaymentController extends Controller
{
    public function send()
    {
        $totalPrice=0;
        $products = session('product');
        $factor_id = time();
        session()->put('factor_number',$factor_id);
        foreach ($products as $product) {
            if ($product[1] !== 0) {
                $factor = new Factor();
                $factor->product_count = $product[1];
                $factor->factor_number = $factor_id;
//                $factor->user_id = auth()->user()->id;
                $factor->user_id = 555;
                $factor->save();
                $factor->products()->attach($product[0]);

//                *********************** sum all price ************************
                $productForPrice=Product::findorfail($product[0]);
                if ($productForPrice->offPrice === 0){
                    $totalPrice=$productForPrice->mainPrice * $product[1] + $totalPrice;
                }else{
                    $totalPrice=$productForPrice->offPrice * $product[1] + $totalPrice;
                }

            }
        }
        $MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'; //Required
        $Amount = $totalPrice; //Amount will be based on Toman - Required $_GET['totalText'];
//        $Amount = $_GET['totalText'];  //Amount will be based on Toman - Required
        $Description = 'توضیحات تراکنش تستی'; // Required
        $Email = 'UserEmail@Mail.Com'; // Optional
        $Mobile = '09123456789'; // Optional
        $CallbackURL = 'https://imtproject.ir/admin/paymentBack'; // Required


        $client = new \SoapClient('https://zarinpal.com/pg/posts/WebGate/wsdl', ['encoding' => 'UTF-8']);
//        var_dump($client->__getFunctions());
        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );

        if ($result->Status == 100) {
            return redirect('https://zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }

        session()->put('totalPrice',$totalPrice);
    }


    public function back()
    {
        $MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
        $Amount = session('totalPrice');
        $Authority = $_GET['Authority'];

        if ($_GET['Status'] == 'OK') {

            $client = new \SoapClient('https://zarinpal.com/pg/posts/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ]
            );

            if ($result->Status == 100) {
                $order = new Order();
                $order->factor_number = session('factor_number');
                $order->user_id = 555;
                $order->refId = $result->RefID ;
                $order->pay_status = 1;
                $order->authority = ltrim($Authority, "0");
                $order->save();
//                echo 'Transaction success. RefID:' . $result->RefID;
                return redirect('https://imtproject.ir/');


            } else {
                $order = new Order();
                $order->factor_number = session('factor_number');
//                $order->user_id = auth()->user()->id;
                $order->user_id = 555;
                $order->pay_status = 0;
                $order->authority = ltrim($Authority, "0");
                $order->refId = 0 ;
                $order->save();
                return redirect('https://imtproject.ir/basket');
            }
        } else {
            $order = new Order();
            $order->factor_number =session('factor_number');
//            $order->user_id = auth()->user()->id;
            $order->user_id = 555;
            $order->pay_status = 0;
            $order->authority = ltrim($Authority, "0");
            $order->refId = 0 ;
            $order->save();
            return redirect('https://imtproject.ir/basket');
        }
    }

}
