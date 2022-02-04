<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingCartController extends Controller
{
    public function addcart(Request $request)
    {

        $product = Product::findorfail($request->id);
        $content = Cart::content()->where('id', $product->id)->first();

        if ($product->discount > 0) {
            $price = $product->price * (100 - $product->discount) / 100;
            $price=round($price);
            $old_price = $product->price;
            $disprice = $product->price-$price;
        } else {
            $price = $product->price;
            $old_price = $product->price;
            $disprice=0;
        }


        if (!empty($content->qty)) {
            if ($product->depot != $content->qty) {
                if ($product->buy_limited!="") {
                    if ($content->qty >= $product->buy_limited) {
                        return response()->json([
                            'msg' => Cart::content(),
                            'countcart' => Cart::content()->count(),
                            'total' => Cart::subtotal(00),
                            'buy_limited'=>'yes',
                        ]);
                    }else{
                        Cart::add($product->id, $product->title, 1, $price, [
                            'image' => asset($product->image),
                            'product_id' => $product->id,
                            'product_view' => $product->view,
                            'product_slug' => $product->slug,
                            'seller_id' => $product->user_id,
                            'type' => $product->type,
                            'disprice' => $disprice,
                            'marginprice' => $product->marginprice,
                            'sale' => $product->sale,
                            'price' => $price,
                            'old_price' => $old_price,
                        ]);
                        foreach (Cart::content() as $cart) {
                            $toral_old_price[] = $cart->options->old_price * $cart->qty;
                            $total_price[] = $cart->price * $cart->qty;
                        }
                        $total_old_p = array_sum($toral_old_price);
                        $total_discount = $total_old_p - array_sum($total_price);
                        return response()->json([
                            'msg' => Cart::content(),
                            'countcart' => Cart::content()->count(),
                            'total_discount' => number_format($total_discount),
                            'total' => Cart::subtotal(00)
                        ]);
                    }
                }else {
                    Cart::add($product->id, $product->title, 1, $price, [
                        'image' => asset($product->image),
                        'product_id' => $product->id,
                        'product_view' => $product->view,
                        'product_slug' => $product->slug,
                        'seller_id' => $product->user_id,
                        'type' => $product->type,
                        'disprice' => $disprice,
                        'marginprice' => $product->marginprice,
                        'sale' => $product->sale,
                        'price' => $price,
                        'old_price' => $old_price,
                    ]);
                    foreach (Cart::content() as $cart) {
                        $toral_old_price[] = $cart->options->old_price * $cart->qty;
                        $total_price[] = $cart->price * $cart->qty;
                    }
                    $total_old_p = array_sum($toral_old_price);
                    $total_discount = $total_old_p - array_sum($total_price);
                    return response()->json([
                        'msg' => Cart::content(),
                        'countcart' => Cart::content()->count(),
                        'total_discount' => number_format($total_discount),
                        'total' => Cart::subtotal(00)
                    ]);
                }
            } else {
                return response()->json([
                    'msg2' => 'notproduct',
                    'msg' => Cart::content(),
                    'countcart' => Cart::content()->count(),
                    'total' => Cart::subtotal(00)
                ]);
            }
        } else {

            Cart::add($product->id, $product->title, 1, $price, [
                'image' => asset($product->image),
                'product_id' => $product->id,
                'product_view' => $product->view,
                'product_slug' => $product->slug,
                'seller_id' => $product->user_id,
                'type' => $product->type,
                'disprice' => $disprice,
                'marginprice' => $product->marginprice,
                'sale' => $product->sale,
                'price' => $price,
                'old_price' => $old_price,
            ]);
            foreach (Cart::content() as $cart){
                $toral_old_price[]=$cart->options->old_price*$cart->qty;
                $total_price[]=$cart->price*$cart->qty;
            }
            $total_old_p=array_sum($toral_old_price);
            $total_discount=$total_old_p-array_sum($total_price);
            return response()->json([
                'msg' => Cart::content(),
                'countcart' => Cart::content()->count(),
                'total_discount' => number_format($total_discount),
                'total' => Cart::subtotal(00)
            ]);
        }

    }

    public function cart()
    {
//        return Cart::content();
//        return Cart::subtotal(00);

    }

    public function removecart(Request $request)
    {
//        $content = Cart::content()->where('id', $request->id)->first();
        Cart::remove($request->id);
        if (count(Cart::content())) {
            foreach (Cart::content() as $cart){
                $toral_old_price[]=$cart->options->old_price*$cart->qty;
                $total_price[]=$cart->price*$cart->qty;
            }
            $total_old_p=array_sum($toral_old_price);
            $total_didcount=$total_old_p-array_sum($total_price);
        }else{
            $total_didcount=0;
        }


        return response()->json([
            'countcart' => Cart::content()->count(),
            'total_discount' => number_format($total_didcount),
            'total' => Cart::subtotal(00)
        ]);

    }

    public function updatecart(Request $request)
    {
        $product = Product::findorfail($request->id);
        $content = Cart::content()->where('id', $request->id)->first();
        if ($product->depot != $content->qyt and $product->depot >= $request->qyt) {
            $price = $product->price * (100 - $product->discount) / 100;
            $price = $price * $request->qyt;
            if ($product->buy_limited!="") {
                if ($request->qyt>$product->buy_limited) {
                    return response()->json([
                        'buy_limited'=>'yes',
                    ]);
                }else{
                    Cart::update($content->rowId, $request->qyt);
                    foreach (Cart::content() as $cart) {
                        $toral_old_price[] = $cart->options->old_price * $cart->qty;
                        $total_price[] = $cart->price * $cart->qty;
                    }
                    $total_old_p = array_sum($toral_old_price);
                    $total_didcount = $total_old_p - array_sum($total_price);
                    return response()->json([
                        'msg' => $request->qyt,
                        'price' => number_format($price),
                        'toral_old_price' => number_format($total_old_p),
                        'total_didcount' => number_format($total_didcount),
                        'countcart' => Cart::content()->count(),
                        'total' => Cart::subtotal(00)
                    ]);
                }
            }else {


                Cart::update($content->rowId, $request->qyt);
                foreach (Cart::content() as $cart) {
                    $toral_old_price[] = $cart->options->old_price * $cart->qty;
                    $total_price[] = $cart->price * $cart->qty;
                }
                $total_old_p = array_sum($toral_old_price);
                $total_didcount = $total_old_p - array_sum($total_price);
                return response()->json([
                    'msg' => $request->qyt,
                    'price' => number_format($price),
                    'toral_old_price' => number_format($total_old_p),
                    'total_didcount' => number_format($total_didcount),
                    'countcart' => Cart::content()->count(),
                    'total' => Cart::subtotal(00)
                ]);
            }
        } else {
            return response()->json([
                'msg2' => 'notproduct',
                'msg' => $request->qyt,
                'countcart' => Cart::content()->count(),
                'total' => Cart::subtotal(00)
            ]);
        }

    }
}
