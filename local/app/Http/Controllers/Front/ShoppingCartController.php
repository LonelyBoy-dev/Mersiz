<?php

namespace App\Http\Controllers\Front;

use App\Model\Conflict;
use App\Product;
use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function addcart(Request $request)
    {

        $user_id = $request->user()->id;
        $product = Product::findorfail($request->product_id);
        $cartCollection = Cart::where('user_id', $user_id)->get();
        $getContent = Cart::where(['product_id' => $request->product_id, 'user_id' => $user_id])->first();

        if (count($cartCollection) != 0) {

            if ($getContent) {
                $qp = $getContent->quantity;
            } else {
                $qp = 0;
            }

            // $qty = $qp + $request->quantity;
            $qty = $request->quantity;
            if ($qty <= $product->depot and $request->quantity <= $product->depot) {

                if (!empty($getContent)) {
                    $getContent->total = $request->quantity;
                    $getContent->save();
                } else {
                    $getContent = new Cart();
                    $getContent->total = $request->quantity;
                    $getContent->product_id = $request->product_id;
                    $getContent->user_id = $user_id;
                    $getContent->save();
                }

                $cartCollection = Cart::where('user_id', $user_id)->get();
                $getContent = Cart::where(['product_id' => $request->product_id, 'user_id' => $user_id])->first();

                foreach ($cartCollection as $item) {
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

                $price = array_sum($total_price);

                return response()->json([
                    'product' => $getContent,
                    'countcart' => count($cartCollection),
                    'totalprice' => round($price, 2)
                ], 201);
            } else {
                return response()->json([
                    'msg2' => 'notproduct',
                    // 'msg' => $cartCollection,
                    // 'countcart' => count($cartCollection),
                    // 'total' => \Cart::getTotal()
                ], 201);
            }
        } else {
            if (1 <= $product->depot) {

                if (!empty($getContent)) {
                    $getContent->total = $request->quantity;
                    $getContent->save();
                } else {
                    $getContent = new Cart();
                    $getContent->total = $request->quantity;
                    $getContent->product_id = $request->product_id;
                    $getContent->user_id = $user_id;
                    $getContent->save();
                }

                $cartCollection = Cart::where('user_id', $user_id)->get();
                $getContent = Cart::where(['product_id' => $request->product_id, 'user_id' => $user_id])->first();

                foreach ($cartCollection as $item) {
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

                $price = array_sum($total_price);

                return response()->json([
                    'product' => $getContent,
                    'countcart' => count($cartCollection),
                    'totalprice' => round($price, 2)
                ], 201);
            } else {
                return response()->json([
                    'msg2' => 'notproduct',
                    // 'msg' => $product_Cart,
                    // 'countcart' => count($cartCollection),
                    // 'total' => \Cart::getTotal()
                ], 201);
            }
        }
    }

    public function CheckCart(Request $request)
    {
        $user_id = $request->user()->id;
        $getContent = Cart::where(['product_id' => $request->product_id, 'user_id' => $user_id])->first();
        if (!empty($getContent)) {
            return response()->json([
                'msg' => 'isProduct',
                'product' => $getContent,
            ], 201);
        } else {
            return response()->json([
                'msg' => 'notProduct',
                'product' => $getContent,
            ], 201);
        }
    }

    public function getCart(Request $request)
    {

        $user_id = $request->user()->id;
        $cartCollection = Cart::where('user_id', $user_id)->get();

        if (!empty($cartCollection->all())) {

            foreach ($cartCollection as $item) {
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
            $price = array_sum($total_price);
        } else {
            $price = 0;
            $product_Cart = [];
        }



        return response()->json([
            'datacart' => $product_Cart,
            'countcart' => count($cartCollection),
            'totalprice' => round($price, 2)
        ], 201);
    }

    public function removecart(Request $request)
    {
        $user_id = $request->user()->id;
        Cart::where(['product_id' => $request->product_id, 'user_id' => $user_id])->delete();

        $cartCollection = Cart::where('user_id', $user_id)->get();

        if (!empty($cartCollection->all())) {

            foreach ($cartCollection as $item) {
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
            $price = array_sum($total_price);
        } else {
            $price = 0;
            $product_Cart = [];
        }

        return response()->json([
            'countcart' => count($cartCollection),
            'totalprice' => round($price, 2)
        ], 201);
    }
}
