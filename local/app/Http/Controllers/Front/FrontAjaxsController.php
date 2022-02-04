<?php

namespace App\Http\Controllers\Front;

use App\Address;
use App\Alert;
use App\Brand;
use App\Category;
use App\Comment;
use App\Discountcode;
use App\Favorite;
use App\Mobile_verified;
use App\Post;
use App\Post_comments;
use App\Postcategory;
use App\Product;
use App\Request_quantity;
use App\Spacial;
use Cookie;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontAjaxsController extends Controller
{
    public function verify_phone_number_code(Request $request){
        $verify_code_number=$request['line_number'];
        $mobile_verified=Mobile_verified::where('mobile',$request->mobile)->first();
        if ($mobile_verified->mobile_verified_at==$verify_code_number) {
            echo 'isTrue';
        }else{
            echo 'isFalse';
        }
    }
    public function deleteItem($id)
    {
//        $idd = $_POST['item'];
        session()->forget("product.$id");
//        return "dfg";
    }

    public function set_view_post(Request $request)
    {
        $view = Post::findorfail($request->id);
        $view->view = $view->view + 1;
        $view->save();
    }

    public function set_view_product(Request $request)
    {
        $view = Product::findorfail($request->id);
        $view->view = $view->view + 1;
        $view->save();
    }

    public function addProductCount(Request $request)
    {
        $id = $_POST['item'];
        $oldCount = session("product.$id.1");
        $newCount = $oldCount + 1;
        $productArray = array($id, $newCount);
        $request->session()->put("product.$id", $productArray);
//        return true;
    }

    public function minusProductCount(Request $request)
    {
        $id = $_POST['item'];
        $newCount = 0;
        $oldCount = session("product.$id.1");
        if ($oldCount != 0)
            $newCount = $oldCount - 1;
        $productArray = array($id, $newCount);
        $request->session()->put("product.$id", $productArray);
//        return true;
    }

    public function commentStore()
    {
        $comment = new Comment();
        $comment->productId = $_POST['productId'];
        $comment->user_id = $_POST['userId'];
        $comment->content = $_POST['content'];
        $comment->parentId = $_POST['parentId'];
        $comment->save();
    }

    public function comment_service_Store()
    {
        $comment = new Post_comments();
        $comment->service_id = $_POST['productId'];
        $comment->user_id = $_POST['userId'];
        $comment->content = $_POST['content'];
        $comment->save();
    }

    public function comment_product_Store()
    {
        $comment = new Comment();
        $comment->product_id = $_POST['productId'];
        $comment->user_id = $_POST['userId'];
        $comment->content = $_POST['content'];
        $comment->save();
    }

    function service_comment_like_dislike(Request $request)
    {
        $Cookie = Cookie::get('service_comment' . $request->id);
        if (!$Cookie) {
            Cookie::queue('service_comment' . $request->id, $request->id, 27 * 24 * 60);
            $service = Post_comments::where('id', $request->id)->first();
            $value = $request->value;
            $service->$value = $service->$value + 1;
            $service->save();
            echo 'ok';
        } else {
            echo 'onelike';
        }
    }

    function product_comment_like_dislike(Request $request)
    {
        $Cookie = Cookie::get('product_comment' . $request->id);
        if (!$Cookie) {
//            session()->put('service_comment'.$request->id,$request->id);
            Cookie::queue('product_comment' . $request->id, $request->id, 27 * 24 * 60);
            $service = Comment::where('id', $request->id)->first();
            $value = $request->value;
            $service->$value = $service->$value + 1;
            $service->save();
            echo 'ok';
        } else {
            echo 'onelike';
        }
    }

    public function add_remove_favorite(Request $request)
    {
        $Favorite = Favorite::where(['user_id' => Auth::id(), 'product_id' => $request->id])->first();
        if (empty($Favorite)) {
            $item = new Favorite();
            $item->user_id = Auth::id();
            $item->product_id = $request->id;
            $item->save();
            echo 'add';
        } else {
            $Favorite->delete();
            echo 'deleted';
        }

    }

    public function delete_favorite(Request $request)
    {
        $item = Favorite::findorfail($request->id);
        if ($item->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }


    public function search(Request $request)
    {
        $products = Product::where('status', 'PUBLISHED')->where('title', 'like', "%" . $request->search . "%")->with('categories')->orderby('id', 'desc')->take(5)->get();
        foreach ($products as $product) {
            ?>
            <div class="col-12" style="background: #fff">
                <div class="card" style="border: none">
                    <a href="/product/<?= $product->slug ?>">
                        <div class="card-body" style="padding: 0px 2px 12px 14px;">


                            <div class="row" style="margin-right: 0">
                                <div class="col-1"
                                     style="padding-right: 0;padding-left: 0;margin-right: 13px;margin-top: 12px">
                                    <img width="50" src="<?= asset($product->image) ?>" alt="">
                                </div>
                                <div class="col-9" style="padding-top: 13px;padding-right: 31px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 style="font-size: 10px;text-align: right; line-height: 2;color: #555"><?= $product->title ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        <?php }
        /* return response([
             'msg'=>$products
         ]);*/

    }

    public function alert_status(Request $request)
    {
        $alert = Alert::where('id', $request->alert_id)->first();
        $alert->status = $request->status;
        $alert->save();
        echo $request->status;
    }



    public function checkdiscountcode(Request $request)
    {
        $discountcode = Discountcode::where('code', $request->code)->first();
        $msg = "";
        $color = "";
        $price = "";
        $dis_price = "0";
        $code="";
        $carts=Cart::content();
        foreach ($carts as $cart){
            $all_price[]=$cart->options->price*$cart->qty;
        }
        $total_price=array_sum($all_price);
        if ($total_price >= setting()['send_price_top']) {
        }else{
            $total_price=$total_price+setting()['send_price'];
        }



        if (!empty($discountcode)) {
            $applicants = Discountcode::where('end_date', '<', \Illuminate\Support\Carbon::now()->format('Y-m-d'))->where('code', $discountcode->code)->first();
            if (!empty($applicants)) {
                $msg = "این کد تخفیف منقضی شده است";
                $color = "red";
                $price = number_format($total_price);
                $dis_price = "0";
            } else {
                if ($discountcode->used >= $discountcode->max) {
                    $msg = "از این کد نمی توانید استفاده کنید";
                    $color = "red";
                    $price =number_format($total_price);
                    $dis_price = "0";
                } else {

                    $price =$total_price * (100 - $discountcode->darsad) / 100;
                    $msg = "ثبت شد";
                    $color = "green";
                    $code=$request->code;
                    $dis_price = number_format($total_price - $price);
                    $price = number_format($price);
                }
            }

        } else {
            $msg = "این کد تخفیف نامعتبر است";
            $color = "red";
            $price = number_format($total_price);
            $dis_price = "0";

        }
        return response([
            'msg' => $msg,
            'color' => $color,
            'price' => $price,
            'code' =>$code,
            'dis_price' => $dis_price,
        ]);
    }
    public function get_info_address(Request $request){
        $address=Address::where(['user_id'=>Auth::id(),'id'=>$request->data_id])->first();
        if ($address->location==""){
            $lat="35.73249";
            $lng="51.42268";
        }else{
            $mapss=explode('(',$address->location);
            $maps=str_replace(array( '(', ')' ), '', $mapss[1]);

            $map=explode(',',$maps);
            $lat=$map[0];
            $lng=$map[1];
        }
        return response([
            'name' => $address->name,
            'mobile' => $address->mobile,
            'address' => $address->address,
            'plaque' => $address->plaque,
            'unit' => $address->unit,
            'postal_code' => $address->postal_code,
            'Map' => $address->location,
            'lat'=>$lat,
            'lng'=>$lng,
        ]);
    }
    public function selectDefault_Address(Request $request){
        Address::where('user_id',Auth::id())->update(['selected'=>"NO"]);
        $address=Address::where(['user_id'=>Auth::id(),'id'=>$request->data_id])->first();
        $address->selected="YES";
        $address->save();
    }
    public function remove_Address(Request $request){
        Address::where(['user_id'=>Auth::id(),'id'=>$request->id])->delete();
        return response([
            'msg' => "success",
        ]);
    }
    public function remove_Comments(Request $request){
        Comment::where(['user_id'=>Auth::id(),'id'=>$request->id])->delete();
        return response([
            'msg' => "success",
        ]);
    }
    public function check_count_product(Request $request){
        $product=Product::find($request->id_product);
        if ($product->depot<=0) {
            Cart::remove($request->id);
            session()->put('check_count_product','به دلیل تمام شدن محصول، به طور خودکار از سبد خرید حذف شد');
            return response([
                'remove' => "yes",
                'id_remove'=>$request->id_product
            ]);
        }
    }
    public function request_quantity(Request $request){
        $Cookie = Cookie::get('request_quantity' . $request->id);
        if (!$Cookie) {
            Cookie::queue('request_quantity' . $request->id, $request->id, 27 * 24 * 60);
            $request_quantity=Request_quantity::where('product_id',$request->id)->first();
            if ($request_quantity){
                $request_quantity->count=$request_quantity->count+1;
            }else{
                $request_quantity=new Request_quantity();
                $request_quantity->user_id=Auth::id();
                $request_quantity->ip=request()->ip();
                $request_quantity->product_id=$request->id;
                $request_quantity->count=1;
            }
            $request_quantity->save();
            return response([
                'msg' => "ok",
            ]);
        }else{
            return response([
                'msg' => "notOk",
            ]);
        }
    }

    public function search_input(Request $request)
    {
        $products=Product::where('title', 'LIKE', '%' . $request->value . '%')->get();
        $categories=Category::where('title', 'LIKE', '%' . $request->value . '%')->get();
        $brands=Brand::where('title', 'LIKE', '%' . $request->value . '%')->get();
        $empty_pro="no";
        $empty_cat="no";
        $empty_brand="no";
        if (!count($products)) {
            $empty_pro="yes";
        }
        if (!count($categories)) {
            $empty_cat="yes";
        }
        if (!count($brands)) {
            $empty_brand="yes";
        }
        return response([
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'empty_pro' => $empty_pro,
            'empty_cat' => $empty_cat,
            'empty_brand' => $empty_brand,
        ]);
    }
}
