<?php

namespace App\Http\Controllers;

use App\Discountcode;
use App\Payment;
use App\Order;
use App\Setting;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function verify(Request $request)
    {
        $address = Cookie::get('Address');

        if (isset($address)) {
            $info_address = unserialize($address);
            $carts = Cart::content();
            $v = new Verta();
            $factor = 'F-' . $v->year . $v->month . $v->day . $v->second . rand(100, 999) . Auth::id();


            $price = Cart::subtotal(00, null, '');
            if ($price >= setting()['send_price_top']) {
                $price = $price;
            } else {
                $price = $price + setting()['send_price'];
            }
            $discountcode_darsad = 0;
            $discountcode = "";
            $Total = Cart::subtotal(00, null, '');
            if (!empty($request->discount_code)) {
                $code = Discountcode::where('code', $request->discount_code)->first();
                if ($code) {
                    $discountcode_darsad = $code->darsad;
                    $discountcode = $code->code;
                    $discount = $price * (100 - $code->darsad) / 100;
                    $price = $discount;
                    $Total = $price;
                }
            }

            if ($info_address['day']=="پست ویژه" and $info_address['time']=="پست ویژه"){


                $price = $price+setting()['send_Special_price'];
                if ($Total<setting()['send_price_top']) {
                    $Total=$Total+setting()['send_price']+setting()['send_Special_price'];
                    $send_price=setting()['send_price']+setting()['send_Special_price'];
                }else{
                    $send_price=setting()['send_Special_price'];
                    $Total = $price+setting()['send_Special_price'];

                }

            }else{
                $send_price="رایگان";
                if ($Total<setting()['send_price_top']) {
                    $Total=$Total+setting()['send_price'];
                    $send_price=setting()['send_price'];
                }
            }

            if ($Total < setting()['Atleast_buy']){
                session()->put('Marketing_price_noFee', 'حداقل مبلغ سفارش بایستی '.number_format(setting()['Atleast_buy']).' تومان باشد. ');
                return redirect('/confirmandsend');
            }else{


                $order = Order::where('user_id', Auth::id())->first();
                $first_buy_mony = 0;
                if ($order == "") {
                    $first_buy_mony = $Total - ($Total * (100 - setting()['first_buy_mony']) / 100);
                    $price = $Total - $first_buy_mony;
                    $Total = $Total - $first_buy_mony;
                }

                if ($request->paymentType == 1) {


                    $payment = new payment($price, 'payment-verify');
                    $result = $payment->doPayment();

                    if ($result->Status == 100) {
                        $code = Discountcode::where('code', $request->discountcode)->first();
                        if ($code) {
                            $code->used = $code->used + 1;
                            $code->save();
                        }

                        foreach ($carts as $cart) {
                            $newPayment = new Order();
                            $newPayment->authority = ltrim($result->Authority, '0');
                            $newPayment->user_id = Auth::id();
                            $newPayment->product_id = $cart->options->product_id;
                            $newPayment->seller_id = $cart->options->seller_id;
                            $newPayment->type = $cart->options->type;
                            $newPayment->price = $cart->options->old_price;
                            $newPayment->payprice = $cart->price;
                            $newPayment->disprice = $cart->options->disprice;
                            $newPayment->sale = $cart->options->sale;
                            $newPayment->count = $cart->qty;
                            $newPayment->name = $info_address['name'];
                            $newPayment->mobile = $info_address['mobile'];
                            $newPayment->state = "";
                            $newPayment->city = "";
                            $newPayment->first_buy_mony = $first_buy_mony;
                            $newPayment->pay_method = "online";
                            $newPayment->send_price = $send_price;
                            $newPayment->total = $Total;
                            $newPayment->address = $info_address['address'];
                            $newPayment->location = $info_address['location'];
                            $newPayment->send_day = $info_address['day'];
                            $newPayment->send_time = $info_address['time'];
                            $newPayment->description = $info_address['description'];
                            $newPayment->reservation = $info_address['reservation'];
                            $newPayment->factor_number = $factor;
                            $newPayment->discountcode = $discountcode;
                            $newPayment->discountcode_darsad = $discountcode_darsad;
                            $newPayment->save();
                        }

                        if (zarinpal_client() == "پرداخت آزمایشی") {
                            return redirect()->to('https://sandbox.zarinpal.com/pg/StartPay/' . $result->Authority);
                        } elseif (zarinpal_client() == "درگاه پرداخت") {
                            return redirect()->to('https://zarinpal.com/pg/StartPay/' . $result->Authority);
                        }
                    } else {
                        echo 'ERR: ' . $result->Status;
                    }
                } elseif ($request->paymentType == 2) {
                    $code = Discountcode::where('code', $request->discountcode)->first();
                    if ($code) {
                        $code->used = $code->used + 1;
                        $code->save();
                    }
                    foreach ($carts as $cart) {
                        $newPayment = new Order();
                        $newPayment->authority = rand(000000000, 999999999);
                        $newPayment->user_id = Auth::id();
                        $newPayment->product_id = $cart->options->product_id;
                        $newPayment->seller_id = $cart->options->seller_id;
                        $newPayment->type = $cart->options->type;
                        $newPayment->price = $cart->options->old_price;
                        $newPayment->payprice = $cart->price;
                        $newPayment->sale = $cart->options->sale;
                        $newPayment->count = $cart->qty;
                        $newPayment->name = $info_address['name'];
                        $newPayment->mobile = $info_address['mobile'];
                        $newPayment->state = "";
                        $newPayment->city = "";
                        $newPayment->first_buy_mony = $first_buy_mony;
                        $newPayment->pay_method = "home";
                        $newPayment->send_price = $send_price;
                        $newPayment->total = $Total;
                        $newPayment->address = $info_address['address'];
                        $newPayment->location = $info_address['location'];
                        $newPayment->send_day = $info_address['day'];
                        $newPayment->send_time = $info_address['time'];
                        $newPayment->description = $info_address['description'];
                        $newPayment->reservation = $info_address['reservation'];
                        $newPayment->factor_number = $factor;
                        $newPayment->discountcode = $discountcode;
                        $newPayment->discountcode_darsad = $discountcode_darsad;
                        $newPayment->save();
                    }
                    Cart::destroy();
                    return redirect('/orderResultInfo/success=True?id=' . $newPayment->authority);
                } elseif ($request->paymentType == 3) {
                    $user = User::find(Auth::id());
                    if ($user->Marketing_price >= $Total) {

                        $code = Discountcode::where('code', $request->discountcode)->first();
                        if ($code) {
                            $code->used = $code->used + 1;
                            $code->save();
                        }

                        foreach ($carts as $cart) {
                            $newPayment = new Order();
                            $newPayment->authority = rand(000000000, 999999999);
                            $newPayment->user_id = Auth::id();
                            $newPayment->product_id = $cart->options->product_id;
                            $newPayment->seller_id = $cart->options->seller_id;
                            $newPayment->type = $cart->options->type;
                            $newPayment->price = $cart->options->old_price;
                            $newPayment->payprice = $cart->price;
                            $newPayment->sale = $cart->options->sale;
                            $newPayment->count = $cart->qty;
                            $newPayment->name = $info_address['name'];
                            $newPayment->mobile = $info_address['mobile'];
                            $newPayment->state = "";
                            $newPayment->city = "";
                            $newPayment->first_buy_mony = $first_buy_mony;
                            $newPayment->pay_method = "wallet";
                            $newPayment->send_price = $send_price;
                            $newPayment->total = $Total;
                            $newPayment->address = $info_address['address'];
                            $newPayment->location = $info_address['location'];
                            $newPayment->send_day = $info_address['day'];
                            $newPayment->send_time = $info_address['time'];
                            $newPayment->description = $info_address['description'];
                            $newPayment->reservation = $info_address['reservation'];
                            $newPayment->factor_number = $factor;
                            $newPayment->discountcode = $discountcode;
                            $newPayment->discountcode_darsad = $discountcode_darsad;
                            $newPayment->save();
                        }
                        $user->Marketing_price = $user->Marketing_price - $Total;
                        $user->save();
                        Cart::destroy();
                        return redirect('/orderResultInfo/success=True?id=' . $newPayment->authority);
                    } else {
                        session()->put('Marketing_price_noFee', 'موجودی کیف پول شما برای خرید کافی نمی باشد');
                        return redirect('/confirmandsend');
                    }
                }
            }
        }
    }
}
