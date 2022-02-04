<?php

namespace App\Http\Controllers;

use App\Allreport;
use App\Discountcode;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Payment;
use App\Order;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    public function verify(Request $request)
    {

        $price = Cart::subtotal(00, null, '');
        $payment = new Payment($price);
        $result = $payment->verifyPayment($request->Authority, $request->Status);

        if ($result) {

            $newPayments = Order::where('authority', ltrim($request->Authority, '0'))->get();

            if (@$newPayments[0]->discountcode!="" and @$newPayments[0]->discountcode_darsad!=0){
                $code = Discountcode::where('code', $newPayments[0]->discountcode)->first();
                if ($code) {
                    $code->used= $code->used+1;
                    $code->save();
                }
            }
            foreach ($newPayments as $newPayment){
                if($newPayment->type == 'دانلودی'){
                    $newPayment->pay_status = $request->Status;
                    $newPayment->refId = $result->RefID;
                    $newPayment->linkdownload = URL::temporarySignedRoute('UserDownloadFile', now()->addMinutes(180), ['id' => $newPayment->product_id,'user' => Auth::id()]);
                    $newPayment->save();
                }else{
                    $newPayment->pay_status = $request->Status;
                    $newPayment->refId = $result->RefID;
                    $newPayment->pay_method = "online";
                    $newPayment->save();
                }
            }

            $carts = Cart::content();
            foreach ($carts as $cart) {
                $newproduct = Product::findorfail($cart->options->product_id);
                $newproduct->depot = $newproduct->depot - $cart->qty;
                $newproduct->sale = $newproduct->sale + $cart->qty;
                $newproduct->save();
            }
            $Marketing_link=Cookie::get('Marketing_link');
            if (isset($Marketing_link)) {
                $user=User::where('Marketing_link',$Marketing_link)->first();
                $user->Marketing_price=$user->Marketing_price+$price * (100 - (100-setting()['Marketing_darsad'])) / 100;
                $user->save();
            }
            $user=User::find(Auth::id());
            if ($user->name=="" and $user->family==""){
                $user_name="کاربر گرامی، ";
            }else{
                $user_name=$user->name.' '.$user->family.' عزیز ';
            }

            $username = trim(setting()['username_sms']);
            $password = trim(setting()['password_sms']);
            $from = "+983000505";
            $pattern_code = "tzwp2q2c0x";
            $to = array($user->mobile);
            $input_data = array("name" => $user_name);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            Cart::destroy();
            session()->put('success_payment', 'پرداخت با موفقیت انجام شد.');

            return redirect('/orderResultInfo/success=True?id='.ltrim($request->Authority, '0'));

        } else {
            $user=User::find(Auth::id());
            if ($user->name=="" and $user->family==""){
                $user_name="کاربر گرامی، ";
            }else{
                $user_name=$user->name.' '.$user->family.' عزیز ';
            }

            $username = trim(setting()['username_sms']);
            $password = trim(setting()['password_sms']);
            $from = "+983000505";
            $pattern_code = "y6qnpuiqbl";
            $to = array($user->mobile);
            $input_data = array("name" => $user_name);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            session()->put('error_payment', 'متاسفانه پرداخت شما انجام نشد! لطفا مجددا امتحان فرمایید.');
            return redirect('/orderResultInfo/success=False');
        }
    }

    public function payments()
    {
        $payments = Payment::where('user_id', Auth::id())->paginate(10);
        return view('admin.payments.index', compact(['payments']));
    }

    public function getprice(Request $request)
    {
        $order = Order::findorfail(2);
        return view('admin.payments.price', compact(['order']));
    }

    public function setprice(Request $request)
    {
        $order = Order::findorfail(2);
        $order->amount = $request->price;
        $order->save();
        return response()->json([
            'message' => $order->amount
        ]);
    }

}
