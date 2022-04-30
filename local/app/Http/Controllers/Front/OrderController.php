<?php

namespace App\Http\Controllers\Front;

use App\Address;
use App\Payment;
use App\Order;
use App\User;
use App\Cart;
use App\Factor;
use App\Http\Controllers\Controller;
use App\Product;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function verify(Request $request)
    {

        $address = Address::where(['id' => $request->address, 'user_id' => $request->id])->first();
        $userId = $request->id;
        $carts = Cart::where('user_id', $userId)->get();

        if (!empty($carts->all())) {

            foreach ($carts as $item) {
                $product = Product::findorfail($item->product_id);
                $product->total = $item->total;
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

        // $this->validate(
        //     $request,
        //     [
        //         'mobile' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric'],
        //         'name' => ['required', 'regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/', 'min:3'],
        //         'address' => ['required',  'min:3'],
        //         'family' => ['required', 'regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/', 'min:3'],
        //         'location' => ['required'],
        //     ],
        //     [
        //         'location.required' => 'آدرس خود را بر روی نقشه مشخص کنید.',
        //         'name.required' => 'نام را وارد کنید.',
        //         'name.min' => 'نام باید حداقل ۳ کاراکتر باشد.',
        //         'name.regex' => 'نام نمی تواند عدد یا حروف لاتین باشد.',
        //         'address.required' => 'آدرس پستی را وارد کنید.',
        //         'address.min' => 'آدرس پستی باید حداقل ۳ کاراکتر باشد.',
        //         'family.required' => 'نام خانوادگی را وارد کنید.',
        //         'family.min' => 'نام خانوادگی باید حداقل ۳ کاراکتر باشد.',
        //         'family.regex' => 'نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
        //         'mobile.digits' => ' شماره موبایل باید 11 رقم باشد.',
        //         'mobile.required' => 'شماره موبایل را وارد کنید.',
        //         'mobile.regex' => 'فرمت شماره موبایل صحیح نیست.',
        //         'mobile.numeric' => 'لطفا مقدار عددی وارد کنید.',
        //     ]
        // );

        $v = new Verta();
        $factorNumber = 'F' . $v->year . $v->month . $v->day . '-' . $v->second . $userId;

        // $price_takhfif = 0;

        // if (!empty($request->takhfif_code)) {
        //     $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //     if ($takhfif) {
        //         if ($takhfif->type == 'takhfif') {
        //             $user_reward = User::where('id', $userId)->with('rewards')->first();
        //             foreach ($user_reward->rewards as $item) {
        //                 if ($request->takhfif_code == $item->copon) {
        //                     $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //                     $price = $price - (($price * $takhfif->percent) / 100);
        //                     $price_takhfif = (($price * $takhfif->percent) / 100);
        //                 }
        //             }
        //         } else {
        //             Session::flash('takhfif_error', 'کد تخفیف وارد شده معتبر نمی باشد!');
        //             return redirect()->back();
        //         }
        //     } else {
        //         Session::flash('takhfif_error', 'کد تخفیف وارد شده معتبر نمی باشد!');
        //         return redirect()->back();
        //     }
        // }

        $payment = new payment($price, 'payment-verify', $userId);
        $result = $payment->doPayment();

        if ($result->Status == 100) {

            foreach ($product_Cart as $cart) {
                $newPayment = new Order();
                $newPayment->product_id = $cart->id;
                $newPayment->price = $cart->price;
                if (!empty($cart->offprice) or $cart->offprice != null) {
                    $newPayment->payprice = $cart->offprice;
                } else {
                    $newPayment->payprice = $cart->price;
                }
                $newPayment->sale = $cart->offprice;
                $newPayment->count = $cart->total;
                $newPayment->factor_number = $factorNumber;
                $newPayment->save();
            }

            $factor = new Factor();
            $factor->authority = ltrim($result->Authority, 'A0');
            $factor->product_count = count($carts);
            $factor->factor_number = $factorNumber;
            $factor->user_id = $userId;
            $factor->name = $address->name;
            $factor->tell = $address->tell;
            $factor->address = $address->address;
            $factor->location = $address->location;
            $factor->description = $address->description;
            $factor->save();

            Cart::where('user_id', $userId)->delete();

            return redirect()->to('https://zarinpal.com/pg/StartPay/' . $result->Authority);
            // return redirect()->to('https://sandbox.zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function verifybefore(Request $request)
    {
        $factorNumber = $request->factor_number;
        $carts = Order::where('factor_number', $request->factor_number)->get();


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

        // $price_takhfif = 0;

        // if (!empty($request->takhfif_code)) {
        //     $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //     if ($takhfif) {
        //         if ($takhfif->type == 'takhfif') {
        //             $user_reward = User::where('id', $userId)->with('rewards')->first();
        //             foreach ($user_reward->rewards as $item) {
        //                 if ($request->takhfif_code == $item->copon) {
        //                     $takhfif = Reward::where('copon', $request->takhfif_code)->first();
        //                     $price = $price - (($price * $takhfif->percent) / 100);
        //                     $price_takhfif = (($price * $takhfif->percent) / 100);
        //                 }
        //             }
        //         } else {
        //             Session::flash('takhfif_error', 'کد تخفیف وارد شده معتبر نمی باشد!');
        //             return redirect()->back();
        //         }
        //     } else {
        //         Session::flash('takhfif_error', 'کد تخفیف وارد شده معتبر نمی باشد!');
        //         return redirect()->back();
        //     }
        // }
        $payment = new payment($price, 'payment-verify-before', $factorNumber);
        $result = $payment->doPayment();
        if ($result->Status == 100) {
            return redirect()->to('https://zarinpal.com/pg/StartPay/' . $result->Authority);
            // return redirect()->to('https://sandbox.zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function factors_user()
    {
        // $factors = Factor::where('user_id', $userId)->get();
        // return view('user.orders.factors', compact(['factors']));
    }

    public function orders_user($factor)
    {
        $orders = Order::where('factor_number', $factor)->get();
        $factor = Factor::where('factor_number', (string)$factor)->first();
        return view('user.orders.orders', compact(['orders', 'factor']));
    }

    public function factors_admin()
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $factors = Factor::orderby('id', 'desc')->paginate(20);
        }

        if (Auth::guard('admin')->user()->role == 1) {
            $factors = Factor::where('send_status', 'NO')->orwhere('send_status', 'SEND')->orderby('id', 'desc')->paginate(20);
        }

        if (Auth::guard('admin')->user()->role == 2) {
            $factors = Factor::where('send_status', 'RECIVE')->orwhere('send_status', 'MAKE')->orderby('id', 'desc')->paginate(20);
        }

        return view('admin.orders.factors', compact(['factors']));
    }

    public function factors_make_admin()
    {
        $factors = Factor::where('send_status', 'Make')->orderby('id', 'desc')->paginate(20);
        return view('admin.orders.factors_make', compact(['factors']));
    }

    public function factors_send_admin()
    {
        $factors = Factor::where('send_status', 'SEND')->orderby('id', 'desc')->paginate(20);
        return view('admin.orders.factors_send', compact(['factors']));
    }

    public function factors_close_admin()
    {
        $factors = Factor::where('send_status', 'CLOSE')->orderby('id', 'desc')->paginate(20);
        return view('admin.orders.factors_close', compact(['factors']));
    }

    public function factors_ready_admin()
    {
        $factors = Factor::where('send_status', 'RECIVE')->orderby('id', 'desc')->paginate(20);
        return view('admin.orders.factors_ready', compact(['factors']));
    }

    public function orders_admin($factor)
    {
        $orders = Order::where('factor_number', $factor)->get();
        $factor = Factor::where('factor_number', $factor)->first();
        return view('admin.orders.orders', compact(['orders', 'factor']));
    }

    public function recive($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->send_status = 'RECIVE';
        $factor->save();
        Session::flash('move_success', 'به آشپزخانه منتقل شد');
        return redirect()->back();
    }

    public function make($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->send_status = 'MAKE';
        $factor->save();
        Session::flash('move_success', 'وضعیت سفارش ، در حال آماده سازی ، قرار گرفت');
        return redirect()->back();
    }

    public function ready($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->send_status = 'READY';
        $factor->save();
        Session::flash('move_success', 'به صف ارسال منتقل شد');
        return redirect()->back();
    }

    public function send($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->send_status = 'SEND';
        $factor->save();
        // $code = rand(10000, 99999);
        // $transport = new Transport();
        // $transport->code = $code;
        // $transport->factor_id = $id;
        // $transport->save();
        // $mobile = User::where('id', $factor->user_id)->first()->mobile;

        /*============= sms =============*/
        // $username = "u-9128445704";
        // $password = '@lemo2021&resturant';
        // $from = "+983000505";
        // $pattern_code = "mgyyj3f1ny";
        // $to = array($mobile);
        // $input_data = array("verification-code" => $code);
        // $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        // $handler = curl_init($url);
        // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($handler);
        /*============= sms =============*/


        Session::flash('move_success', 'سفارش در وضعیت تحویل به پیک قرار گرفت');
        return redirect()->back();
    }

    public function close($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->send_status = 'CLOSE';
        $factor->save();
        Session::flash('move_success', 'سفارش بسته شد');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $factors = Factor::where('factor_number', 'like', '%' . $request->query_text . '%')->orderby('id', 'desc')->paginate(10);
        return view('admin.orders.result_search', compact(['factors']));
    }
}
