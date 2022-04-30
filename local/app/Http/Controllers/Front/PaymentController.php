<?php

namespace App\Http\Controllers\Front;

use App\Allreport;
use App\Cart;
use App\Commission_sale;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Card;
use App\Payment;
use App\Order;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\URL;
use Modules\Reward\Entities\Reward;
use Illuminate\Support\Facades\Session;
use Modules\Reward\Entities\Rating;
use App\Factor;

class PaymentController extends Controller
{
    public function verify(Request $request)
    {
        $userId = $request->param;
        $factor = Factor::where('user_id', $userId)->first();
        $carts = Order::where('factor_number', $factor->factor_number)->get();

        if (!empty($carts->all())) {

            foreach ($carts as $item) {
                $product = Product::findorfail($item->product_id);
                $product->total = $item->count;
                $product_Cart[] = $product;
            }

            foreach ($product_Cart as $item) {
                if ($item->offprice == null or empty($item->offprice)) {
                    $total_price[] = $item->price * $item->total;
                } else {
                    $total_price[] = $item->offprice * $item->total;
                }
            }
            $price = round(array_sum($total_price), 2);
        } else {
            $price = 0;
            $product_Cart = [];
        }


        // if (!empty($request->takhfif)) {
        //     $user_reward = User::where('id', Auth::id())->with('rewards')->first();
        //     foreach ($user_reward->rewards as $item) {
        //         if ($request->takhfif_code == $item->copon) {
        //             $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //             $price = $price - (($price * $takhfif->percent) / 100);
        //         }
        //     }
        // }

        $payment = new Payment($price);
        $result = $payment->verifyPayment($request->Authority, $request->Status);

        if ($result) {

            $factor = Factor::where('authority', ltrim($request->Authority, '0A'))->first();
            $factor->pay_status = $request->Status;
            $factor->send_status = 'RECIVE';
            $factor->refId = $result->RefID;
            $factor->save();


            foreach ($product_Cart as $cart) {
                $foods = Product::where('id', $cart->id)->first();
                $foods->depot = $foods->depot - $cart->total;
                $foods->save();
            }



            // if (!empty($request->takhfif)) {
            //     $reward = Reward::where('copon', $request->takhfif)->first();
            //     $reward->users()->detach(Auth::id());
            // }
            // $timefood = Factor::where('user_id', $orders[0]->user_id)->first()->time_food;

            $factor = $factor->factor_number;
            $mobile = User::where('id', $userId)->first()->mobile;

            /*============= sms =============*/
            // $username = "u-9128445704";
            // $password = '@lemo2021&resturant';
            // $from = "+983000505";
            // $pattern_code = "rudz4ma8bi";
            // $to = array($mobile);
            // $input_data = array("verification-code" => round($timefood));
            // $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            // $handler = curl_init($url);
            // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($handler);
            /*============= sms =============*/

            /*============= sms =============*/
            // $username = "u-9128445704";
            // $password = '@lemo2021&resturant';
            // $from = "+983000505";
            // $pattern_code = "pcclolvxpk";
            // $to = array($mobile);
            // $input_data = array("verification-code" => $factor);
            // $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            // $handler = curl_init($url);
            // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($handler);
            /*============= sms =============*/

            // session()->put('success_payment', 'پرداخت با موفقیت انجام شد.');
            // return redirect('/user/factors');
            return 'پرداخت با موفقیت انجام شد';
        } else {
            session()->put('error_payment', 'متاسفانه پرداخت شما انجام نشد! لطفا مجددا امتحان فرمایید.');
            return redirect('/login');
        }
    }

    public function verifybefore(Request $request)
    {
        $factorNumber = $request->param;
        $carts = Order::where('factor_number', $factorNumber)->get();

        foreach ($carts as $item) {
            $product = Product::findorfail($item->product_id);
            $product->total = $item->count;
            $product_Cart[] = $product;

            $item->price = $product->price;
            if (!empty($product->offprice) or $product->offprice != null) {
                $item->payprice = $product->offprice;
            } else {
                $item->payprice = $product->price;
            }
            $item->sale = $product->offprice;
            $item->save();
        }

        foreach ($product_Cart as $item) {
            if ($item->offprice == null or empty($item->offprice)) {
                $total_price[] = $item->price * $item->total;
            } else {
                $total_price[] = $item->offprice * $item->total;
            }
        }
        $price = round(array_sum($total_price), 2);



        // if (!empty($request->takhfif)) {
        //     $user_reward = User::where('id', Auth::id())->with('rewards')->first();
        //     foreach ($user_reward->rewards as $item) {
        //         if ($request->takhfif_code == $item->copon) {
        //             $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //             $price = $price - (($price * $takhfif->percent) / 100);
        //         }
        //     }
        // }

        $payment = new Payment($price);
        $result = $payment->verifyPayment($request->Authority, $request->Status);

        if ($result) {

            $factor = Factor::where('factor_number', $factorNumber)->first();
            $factor->pay_status = $request->Status;
            $factor->send_status = 'RECIVE';
            $factor->refId = $result->RefID;
            $factor->authority = ltrim($request->Authority, '0A');
            $factor->save();


            foreach ($product_Cart as $cart) {
                $foods = Product::where('id', $cart->id)->first();
                $foods->depot = $foods->depot - $cart->total;
                $foods->save();
            }



            // if (!empty($request->takhfif)) {
            //     $reward = Reward::where('copon', $request->takhfif)->first();
            //     $reward->users()->detach(Auth::id());
            // }
            // $timefood = Factor::where('user_id', $orders[0]->user_id)->first()->time_food;

            // $factor = $factor->factor_number;
            // $mobile = User::where('id', $userId)->first()->mobile;

            /*============= sms =============*/
            // $username = "u-9128445704";
            // $password = '@lemo2021&resturant';
            // $from = "+983000505";
            // $pattern_code = "rudz4ma8bi";
            // $to = array($mobile);
            // $input_data = array("verification-code" => round($timefood));
            // $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            // $handler = curl_init($url);
            // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($handler);
            /*============= sms =============*/

            /*============= sms =============*/
            // $username = "u-9128445704";
            // $password = '@lemo2021&resturant';
            // $from = "+983000505";
            // $pattern_code = "pcclolvxpk";
            // $to = array($mobile);
            // $input_data = array("verification-code" => $factor);
            // $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            // $handler = curl_init($url);
            // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($handler);
            /*============= sms =============*/

            // session()->put('success_payment', 'پرداخت با موفقیت انجام شد.');
            // return redirect('/user/factors');
            return 'پرداخت با موفقیت انجام شد';
        } else {
            session()->put('error_payment', 'متاسفانه پرداخت شما انجام نشد! لطفا مجددا امتحان فرمایید.');
            return redirect('/login');
        }
    }

    public function payments()
    {
        $payments = Payment::where('user_id', Auth::id())->paginate(10);
        return view('admin.payments.index', compact(['payments']));
    }
}
