<?php

namespace App\Http\Controllers\Front;

use App\About;
use App\Address;
use App\Attribute;
use App\Attribute_category;
use App\Banner;
use App\Brand;
use App\News;
use App\Category;
use App\Club;
use App\Contact;
use App\Faq;
use App\Feature;
use App\Gallery;
use App\Order;
use App\Page;
use App\Post_comments;
use App\Postcategory;
use App\Attribute_product;
use App\Privacy;
use App\Proposalimage;
use App\Setting;
use App\Slider;
use App\User;
use App\Favorite;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Comment;
use Jenssegers\Agent\Agent;
use function Cassandra\Type;
use function GuzzleHttp\Promise\all;

class FrontController extends Controller
{
    public function verify_phone_number()
    {
        if (session('user-verify-phone-number')) {
           $title='تائید شماره موبایل';
            $seo_title="سئو تائید شماره موبایل";
            $seo_content="سئو تائید شماره موبایل";
            return view('auth.verify-phone-number',compact('title','seo_title','seo_content'));
        } else {
            return redirect('/');
        }

    }

    public function register_user_setEmail()
    {
        if (session('register-new-user-setEmail')) {
                $title='ثبت رمز عبور';
            $seo_title="سئو ثبت رمز عبور";
            $seo_content="سئو ثبت رمز عبور";
            return view('auth.set-email',compact('title','seo_title','seo_content'));
        } else {
            return redirect('/');
        }

    }

    public function index()
    {
        $Marketing_link=@$_GET['Link'];
        if (!empty($Marketing_link)) {
            $user=User::where('Marketing_link',$Marketing_link)->first();
            if (!empty($user) and $user->id!=Auth::id()) {
                Cookie::queue('Marketing_link', $Marketing_link,  time()+60*60*24*30);
            }
        }
        $products_new = Product::where('status', 'PUBLISHED')->orderby('id', 'desc')->take(12)->get();
        $products_view = Product::where('status', 'PUBLISHED')->orderby('view', 'desc')->take(12)->get();
        $products_discount = Product::where(['status'=> 'PUBLISHED','day_basket'=>'NO'])->where('discount', '!=', '0')->orderby('discount','Desc')->take(12)->get();
        $day_baskets = Product::where('status', 'PUBLISHED')->where('day_basket','YES')->orderby('discount','Desc')->take(8)->get();
        $spacial_product = Product::where(['special' => 'YES', 'status' => 'PUBLISHED'])->orderby('id', 'desc')->take(4)->get();
        $product_rand = Product::where('status', 'PUBLISHED')->where('discount', '!=', '0')->orderByRaw("RAND()")->take(7)->get();
        $sale_product = Product::where('status', 'PUBLISHED')->orderby('sale', 'desc')->take(8)->get();
        $categories_image = Category::where('showindex','!=', 'NO')->get();
        $categories = Category::where('parent', '0')->get();

        $posts = Post::where('status', 'PUBLISHED')->with('postcategories')->orderby('id', 'desc')->take(10)->get();

        $cat=Postcategory::where('slug','اعلانات')->first();
        $cat=@$cat->slug;
        $Announcements = Post::whereHas('postcategories', function ($q) use ($cat) {
            $q->where('postcategories.slug', $cat);
        })->get();
        $newss=News::where('status', 'Show')->get();
        $sliders = Slider::where('status', 'Show')->get();
        $banners = Banner::where('status', 'Show')->get();
        $brands = Brand::where('status', 'Show')->orderby('title','ASC')->get();
        $Proposals = Proposalimage::where('status', 'Show')->get();

        $options = Setting::all();
        $setting = array();
        foreach ($options as $option) {
            $name = $option['setting'];
            $value = $option['value'];
            $setting[$name] = $value;
        }
        $title = $setting['title'];
        $seo_title = $setting['seo_title'];
        $seo_content = $setting['seo_content'];

        return view('front.index.index', compact('title','newss', 'seo_title', 'seo_content', 'categories_image', 'categories', 'products_new', 'products_view', 'spacial_product', 'products_discount', 'sale_product', 'posts', 'sliders', 'banners', 'setting', 'brands','product_rand','Announcements','day_baskets','Proposals'));
    }

    public function blog_index()
    {
        @$cat = $_GET['cat'];

        if ($cat) {
            $posts = Post::whereHas('postcategories', function ($q) use ($cat) {
                $q->where('postcategories.slug', $cat);
            })->paginate(10);
        } else {
            $posts = Post::where('status', 'PUBLISHED')->with('postcategories')->orderby('id', 'desc')->paginate(10);
        }
        $posts_rand = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw("RAND()")->take(2)->get();
        $last_posts = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('id', 'desc')->take(5)->get();
        $posts_view = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('view', 'desc')->take(2)->get();
        $categories = Postcategory::all();
        $title = "مقالات | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو مقالات";
        $seo_content = "سئو مقالات";

        return view('front.blog.index', compact('title', 'seo_title', 'seo_content', 'posts', 'categories', 'posts_rand', 'last_posts', 'posts_view'));
    }

    public function blog($slug)
    {
        $posts_rand = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw("RAND()")->take(3)->get();
        $categories = Postcategory::all();

        $post = Post::where(['status' => 'PUBLISHED', 'slug' => $slug])->with('postcategories')->first();
        if($post!=""){
            $comments = Post_comments::where(['post_id' => $post->id, 'status' => 'SEEN', 'parent' => '0'])->get();
            $last_posts = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('id', 'desc')->take(5)->get();
            $posts_view = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('view', 'desc')->take(2)->get();
            $like_posts = collect([]);
            foreach ($post->postcategories as $val) {
                $category_posts = $val->post;
                foreach ($category_posts as $post2) {
                    if ($post->id != $post2->id) {
                        if (!$like_posts->contains('id', $post2->id)) {
                            $like_posts->push($post2);
                        }
                    }

                }
            }

            $title = $post->title.' | سوپر مارکت قزوین مرسیز';
            $seo_title = $post->seoTitle;
            $seo_content = $post->seoContent;
            return view('front.blog.show', compact('title', 'seo_title', 'seo_content', 'post', 'categories', 'posts_rand', 'last_posts', 'posts_view', 'comments', 'like_posts'));
        }else{
            return abort(404);
        }

    }

    public function blog_search()
    {
        $title = Input::get('keyword');
        $posts = Post::where('status', 'PUBLISHED')->where('title', 'like', "%" . $title . "%")->with('postcategories')->orderby('id', 'desc')->paginate(6);
        $posts_rand = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw("RAND()")->take(3)->get();
        $last_posts = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('id', 'desc')->take(4)->get();
        $posts_view = Post::where('status', 'PUBLISHED')->with('postcategories')->orderByRaw('view', 'desc')->take(4)->get();
        $categories = Postcategory::all();
        $title = " جستجو " . $title . " | مقالات";
        $seo_title = "سئو مقالات";
        $seo_content = "سئو مقالات";

        return view('front.blog.index', compact('title', 'seo_title', 'seo_content', 'posts', 'categories', 'posts_rand', 'last_posts', 'posts_view'));
    }

    public function comment_post(Request $request)
    {
        $comment = new Post_comments();
        $comment->name = $request->name;
        $comment->content = $request->input('content');
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post;
        $comment->email = $request->email;
        $comment->save();
        session()->put('save_comment', 'نظر شما با موفقیت دخیره شده و بعد از تائید مدیر در سایت نمایش داده می شود');
        return redirect()->back();
    }

    public function contact()
    {
        $options = Setting::all();
        $brands = Brand::where('status', 'Show')->get();
        $setting = array();
        foreach ($options as $option) {
            $name = $option['setting'];
            $value = $option['value'];
            $setting[$name] = $value;
        }
        $title = "تماس باما | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو تماس باما";
        $seo_content = "سئو تماس باما";
        return view('front.contact.index', compact(['title', 'seo_title', 'seo_content', 'setting', 'brands']));
    }

    public function shop(Request $request,$slug = "",$brand="")
    {
        $page=12;
        $pageNum2=0;
        if($slug) {
            if ($request->sort) {
                if ($request->attribute) {
                    $productItems = Product::whereHas('categories', function ($q) use ($slug) {
                        $q->where('categories.slug', $slug);
                    })->select('id')->get();
                    foreach ($productItems as $item) {
                        $items[] = $item->id;
                    }
                    $attr = $request->attribute;

                    $attr = explode(',', $attr[0]);
                    $attribute_product = Attribute_product::whereIn('attribute_value_id', $attr)->select('product_id')->get();
                    $products = [];

                    foreach ($attribute_product as $product) {
                        $products[] = $product->product_id;
                    }

                    $attribute_products = array_intersect($products, $items);
                    //dd(array_diff_assoc($attribute_products,array_unique($attribute_products)));
                    if (count(array_diff_assoc($attribute_products, array_unique($attribute_products)))) {
                        $attribute_products = array_diff_assoc($attribute_products, array_unique($attribute_products));
                    }


                } else {
                    $slug = $request->slug;
                    $productItems = Product::whereHas('categories', function ($q) use ($slug) {
                        $q->where('categories.slug', $slug);
                    })->select('id')->get();
                    $attribute_products = $productItems;
                }

                $exist = "999999999";
                $ex = "<";
                if ($request->exist == "yes") {
                    $exist = "0";
                    $ex = ">";
                }

                if ($request->limit) {
                    $limit = $request->limit;
                } else {
                    $limit = 12;
                }
                if ($request->sort) {

                    if ($request->sort == "new") {
                        $sort1 = 'id';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "sale") {
                        $sort1 = 'sale';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "view") {
                        $sort1 = 'view';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "priceLow") {
                        $sort1 = 'price';
                        $sort2 = 'asc';
                    }
                    if ($request->sort == "priceHigh") {
                        $sort1 = 'price';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "discount") {
                        $sort1 = 'discount';
                        $sort2 = 'desc';
                    }

                }

                if ($request->amount) {
                    $amounts = explode('|', $request->amount);
                    $min = $amounts[0];
                    $max = $amounts[1];
                    $min = preg_replace('/[^0-9]/', '', $min);
                    $max = preg_replace('/[^0-9]/', '', $max);
                }
                $pageNum = count($attribute_products);
                $page = $limit;
                if ($pageNum >= $limit) {
                    $pageNum = round($pageNum / $limit);
                    $pageNum2 = $pageNum;
                } else {
                    $pageNum = $limit;
                    $pageNum2 = 0;

                }

                $productItems = Product::where([['status', 'PUBLISHED'], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->whereIn('id', $attribute_products)->orderby($sort1, $sort2)->paginate($page);
            } else {
                if ($slug) {
                    $productItems = Product::whereHas('categories', function ($q) use ($slug) {
                        $q->where('categories.slug', $slug);
                    })->paginate(12);
                } else {
                    $productItems = Product::where('status', 'PUBLISHED')->with('categories')->orderby('id', 'desc')->paginate($page);
                }
            }
        }else{
            if ($request->sort) {
                $exist = "999999999";
                $ex = "<";
                if ($request->exist == "yes") {
                    $exist = "0";
                    $ex = ">";
                }

                if ($request->limit) {
                    $limit = $request->limit;
                } else {
                    $limit = 12;
                }
                if ($request->sort) {

                    if ($request->sort == "new") {
                        $sort1 = 'id';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "sale") {
                        $sort1 = 'sale';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "view") {
                        $sort1 = 'view';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "priceLow") {
                        $sort1 = 'price';
                        $sort2 = 'asc';
                    }
                    if ($request->sort == "priceHigh") {
                        $sort1 = 'price';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "discount") {
                        $sort1 = 'discount';
                        $sort2 = 'desc';
                    }

                }

                if ($request->amount) {
                    $amounts = explode('|', $request->amount);
                    $min = $amounts[0];
                    $max = $amounts[1];
                    $min = preg_replace('/[^0-9]/', '', $min);
                    $max = preg_replace('/[^0-9]/', '', $max);
                }
                $all_pro_item=$productItems = Product::where('status', 'PUBLISHED')->get();
                $pageNum = count($all_pro_item);
                $page = $limit;
                if ($pageNum >= $limit) {
                    $pageNum = round($pageNum / $limit);
                    $pageNum2 = $pageNum;
                } else {
                    $pageNum = $limit;
                    $pageNum2 = 0;

                }

                $productItems = Product::where([['status', 'PUBLISHED'], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->orderby($sort1, $sort2)->paginate($page);
            }else{
                $productItems = Product::where('status', 'PUBLISHED')->with('categories')->orderby('id', 'desc')->paginate($page);

            }
        }

        $spacial_product = Product::where(['special' => 'YES', 'status' => 'PUBLISHED'])->orderby('id', 'desc')->take(6)->get();
        $sales=Product::where('status','PUBLISHED')->orderby('sale','desc')->take(6)->get();
        $category = Category::where(['slug'=>$slug])->first();

        $products_new = Product::where('status', 'PUBLISHED')->orderby('id', 'desc')->take(11)->get();
        $products_discount = Product::where('status', 'PUBLISHED')->where('discount', '!=', '0')->take(11)->get();
        //$attributes = Attribute::with('attribute_values')->where('inshop', 'YES')->get();
        $attributes = Attribute::whereHas('categories', function ($q) use ($slug) {
            $q->where('categories.slug', $slug);
        })->where('inshop', 'YES')->get();
        $categories="";


        if ($category!=""){
            $title=$category->title.' | سوپر مارکت قزوین مرسیز';
        }else{
            $title='فروشگاه | سوپر مارکت قزوین مرسیز';
        }
        $seo_title="سئو فروشگاه";
        $seo_content="سئو فروشگاه";

        return view('front.shop.index', compact('slug','category','title','seo_title','seo_content','productItems', 'categories', 'products_new', 'products_discount', 'attributes','sales','spacial_product','page','pageNum2'));
        /*return view('front.shop.index', compact('category'));*/
    }


    public function brandshop(Request $request,$slug = "")
    {
        $page=12;
        $pageNum2=0;
        $brand=Brand::where('link',$slug)->first();
            if ($request->sort) {
                $exist = "999999999";
                $ex = "<";
                if ($request->exist == "yes") {
                    $exist = "0";
                    $ex = ">";
                }

                if ($request->limit) {
                    $limit = $request->limit;
                } else {
                    $limit = 12;
                }
                if ($request->sort) {

                    if ($request->sort == "new") {
                        $sort1 = 'id';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "sale") {
                        $sort1 = 'sale';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "view") {
                        $sort1 = 'view';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "priceLow") {
                        $sort1 = 'price';
                        $sort2 = 'asc';
                    }
                    if ($request->sort == "priceHigh") {
                        $sort1 = 'price';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "discount") {
                        $sort1 = 'discount';
                        $sort2 = 'desc';
                    }

                }

                if ($request->amount) {
                    $amounts = explode('|', $request->amount);
                    $min = $amounts[0];
                    $max = $amounts[1];
                    $min = preg_replace('/[^0-9]/', '', $min);
                    $max = preg_replace('/[^0-9]/', '', $max);
                }
                $all_pro_item=$productItems = Product::where('status', 'PUBLISHED')->get();
                $pageNum = count($all_pro_item);
                $page = $limit;
                if ($pageNum >= $limit) {
                    $pageNum = round($pageNum / $limit);
                    $pageNum2 = $pageNum;
                } else {
                    $pageNum = $limit;
                    $pageNum2 = 0;

                }

                $productItems = Product::where([['status', 'PUBLISHED'],['brand',$brand->id], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->orderby($sort1, $sort2)->paginate($page);
            }else{

                $productItems = Product::where(['status'=> 'PUBLISHED','brand'=>$brand->id])->with('categories')->orderby('id', 'desc')->paginate($page);

            }


        $spacial_product = Product::where(['special' => 'YES', 'status' => 'PUBLISHED'])->orderby('id', 'desc')->take(6)->get();
        $sales=Product::where('status','PUBLISHED')->orderby('sale','desc')->take(6)->get();
        $category = Category::where(['slug'=>$slug])->first();

        $products_new = Product::where('status', 'PUBLISHED')->orderby('id', 'desc')->take(11)->get();
        $products_discount = Product::where('status', 'PUBLISHED')->where('discount', '!=', '0')->take(11)->get();
        //$attributes = Attribute::with('attribute_values')->where('inshop', 'YES')->get();
        $brands=Brand::where('status','Show')->get();
        $attributes = [];
        $categories="";


        if ($category!=""){
            $title=$category->title.' | سوپر مارکت قزوین مرسیز';;
        }else{
            $title='فروشگاه | سوپر مارکت قزوین مرسیز';
        }
        $seo_title="سئو فروشگاه";
        $seo_content="سئو فروشگاه";

        return view('front.shop.brandshop', compact('slug','category','title','seo_title','seo_content','productItems', 'categories', 'products_new', 'products_discount', 'attributes','sales','spacial_product','page','pageNum2','brands'));
        /*return view('front.shop.index', compact('category'));*/
    }


    public function product($slug = null)
    {
        $product = Product::where(['status'=> 'PUBLISHED','slug' => $slug])->first();
        if ($product!=""){
            $images = Gallery::where(['product_id' => $product->id, 'type' => 'product'])->get();
            $featurs = Feature::where('product_id', $product->id)->get();
            $brand=Brand::find($product->brand);
            $comments=Comment::where(['product_id'=>$product->id,'status'=>'SEEN','parent'=>'0'])->with('user')->get();
            $sales=Product::where('status','PUBLISHED')->orderby('sale','desc')->take(7)->get();
            $spacial_product = Product::where(['special' => 'YES', 'status' => 'PUBLISHED'])->orderby('id', 'desc')->take(6)->get();
            $like_products = collect([]);
            foreach ($product->categories as $val) {
                $category_products = $val->products;
                foreach ($category_products as $product2) {
                    if ($product->id != $product2->id) {
                        if (!$like_products->contains('id', $product2->id)) {
                            $like_products->push($product2);
                        }
                    }

                }
            }
            $categories = Category::where('parent', '0')->get();


            $title=$product->title.' | سوپر مارکت قزوین مرسیز';
            $seo_title=$product->title_seo;
            $seo_content=$product->meta_description;
            return view('front.shop.show', compact('title','seo_title','seo_content','product', 'categories', 'images', 'like_products', 'featurs','comments','sales','spacial_product','brand','slug'));
        }else{
            return abort(404);
        }

    }

    public function comment_product(Request $request)
    {
        if (Auth::user()){
            $comment = new Comment();
            $comment->title = $request->title;
            $comment->content = $request->input('content');
            $comment->user_id = Auth::id();
            $comment->product_id = $request->pro;
            $comment->rating = $request->rating;
            $comment->save();
            session()->put('save_comment', 'نظر شما با موفقیت دخیره شده و بعد از تائید مدیر در سایت نمایش داده می شود');
            return redirect()->back();
        }else{
            return redirect('/login');
        }

    }

    public function cart()
    {
        $user = User::find(Auth::id());

        $options = Setting::all();
        $setting = array();
        foreach ($options as $option) {
            $name = $option['setting'];
            $value = $option['value'];
            $setting[$name] = $value;
        }

        $title = 'سبد خرید | سوپر مارکت قزوین مرسیز';
        $seo_title = "سئو سبد خرید";
        $seo_content = "توضیحات سبد خرید";
        return view('front.shop.cart', compact(['title', 'seo_title', 'seo_content', 'user', 'setting']));


    }

    public function sendorder()
    {
        $carts=Cart::content();
        if (count($carts)) {
            if(Auth::user()){
                $address="";
                $addresses=Address::where('user_id',Auth::id())->get();
                if (count($addresses)) {
                    $address=Address::where(['user_id'=>Auth::id(),'selected'=>"YES"])->first();
                    if ($address=="") {
                        $address=Address::where(['user_id'=>Auth::id()])->first();
                        $address->selected="YES";
                        $address->save();
                    }
                }
            }else{
                return redirect('/login');
            }


            $title = 'کی و کجا؟ | سوپر مارکت قزوین مرسیز';
            $seo_title = "سئو کی و کجا";
            $seo_content = "توضیحات کی و کجا";
            return view('front.shop.sendorder',compact(['title', 'seo_title', 'seo_content','addresses','address']));
        }else{
            return redirect('/cart');
        }

    }

    public function confirmandsend()
    {
        $carts=Cart::content();
        if (count($carts)) {
            $address=Cookie::get('Address');
            if(isset($address)){
                $user=User::find(Auth::id());
                $order=Order::where('user_id',Auth::id())->first();
                $address=unserialize($address);


                $title = 'نحوه پرداخت | سوپر مارکت قزوین مرسیز';
                $seo_title = "سئو نحوه پرداخت";
                $seo_content = "توضیحات نحوه پرداخت";
                return view('front.shop.confirmandsend',compact('title', 'seo_title', 'seo_content','user','order','address'));
            }else{
                return redirect('/sendorder');
            }

        }else{
            return redirect('/cart');
        }
    }

    public function confirmandsend_store(Request $request)
    {
        $address=Address::where(['user_id'=>Auth::id(),'selected'=>"YES"])->first();

        if (empty($address)) {
            if ($request->input('transfree-name')=="" and $request->input('address-string')=="" and $request->input('address-plaqu')=="" and $request->input('address-mobile')==""  ) {
                session()->put('error-sendorder-back','لطفا آدرس تحویل سفارش خود را انتخاب نمایید');
                return redirect('/sendorder');
            }
        }else{
            if ($request->shipping_3530==1){
                $name = $address->name;
                $address_user = $address->address . ' پلاک ' . $address->plaque . ' واحد ' . $address->unit . ' کدپستی ' . $address->postal_code;
                $mobile = $address->mobile;
                $location = $address->location;
                $day = "پست ویژه";
                $time = "پست ویژه";
                $reservation = "no";
                $value = [
                    'name' => $name,
                    'address' => $address_user,
                    'mobile' => $mobile,
                    'location' => $location,
                    'day' => $day,
                    'time' => $time,
                    'reservation' => $reservation,
                    'description' => $request->description,
                ];

                $value = serialize($value);
                Cookie::queue('Address', $value, time() + 60 * 15);
                return redirect('/confirmandsend');
            }else {
                if ($request->deliveryTime != "" and $request->datetimepicker == "" and $request->datetimepicker_time == "" or $request->deliveryTime == "" and $request->datetimepicker != "" and $request->datetimepicker_time != "") {

                    $name = $address->name;
                    $address_user = $address->address . ' پلاک ' . $address->plaque . ' واحد ' . $address->unit . ' کدپستی ' . $address->postal_code;
                    $mobile = $address->mobile;
                    $location = $address->location;

                    if ($request->datetimepicker == "") {
                        $day = $request->day_send;
                        $time = $request->deliveryTime;
                        $reservation = "no";
                    } else {
                        $day = $request->datetimepicker;
                        $time = $request->datetimepicker_time;
                        $reservation = "yes";
                    }
                    $value = [
                        'name' => $name,
                        'address' => $address_user,
                        'mobile' => $mobile,
                        'location' => $location,
                        'day' => $day,
                        'time' => $time,
                        'reservation' => $reservation,
                        'description' => $request->description,
                    ];

                    $value = serialize($value);
                    Cookie::queue('Address', $value, time() + 60 * 15);
                    return redirect('/confirmandsend');
                } else {
                    session()->put('error-sendorder-back', 'لطفا زمان ارسال کالای خود را انتخاب نمائید');
                    return redirect('/sendorder');

                }
            }
        }


    }

    public function faq()
    {
        $title='سوالات متداول | سوپر مارکت قزوین مرسیز';
        $seo_title="سئو سوالات متداول";
        $seo_content="سئو سوالات متداول";
        $faqs=Faq::where('status','PUBLISHED')->get();
        return view('front.faq.index',compact('faqs','title','seo_title','seo_content'));
    }

    public function orderResultInfo()
    {
        $orders=Order::where('authority',@$_GET['id'])->get();
        return view('front.shop.orderResultInfo',compact('orders'));
    }

    public function privacy()
    {
        $privacy=About::find(2);
        $title = "حریم خصوصی | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو حریم خصوصی";
        $seo_content = "سئو حریم خصوصی";
        return view('front.privacy.index',compact('title', 'seo_title', 'seo_content', 'privacy'));
    }


    public function returnpolicy()
    {
        $returnpolicy=About::find(3);
        $title = "شرایط مرجوعی کالا | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو شرایط مرجوعی کالا";
        $seo_content = "توضیحات سئو شرایط مرجوعی کالا";
        return view('front.returnpolicy.index',compact('title', 'seo_title', 'seo_content', 'returnpolicy'));
    }



    public function transferpolicy()
    {
        $transferpolicy=About::find(4);
        $title = "شرایط مرجوعی کالا | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو شرایط مرجوعی کالا";
        $seo_content = "توضیحات سئو شرایط مرجوعی کالا";
        return view('front.transferpolicy.index',compact('title', 'seo_title', 'seo_content', 'transferpolicy'));
    }


    public function guide()
    {
        $guide=About::find(5);
        $title = "راهنمای سایت | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو راهنمای سایت";
        $seo_content = "توضیحات سئو راهنمای سایت";
        return view('front.guide.index',compact('title', 'seo_title', 'seo_content', 'guide'));
    }


    public function comment($slug,$id="")
    {

        $product=Product::where('slug',$slug)->first();
        $comment=Comment::find($id);
        return view('front.shop.comment',compact('product','comment'));
    }

    public function comment_store(Request $request,$slug,$id="")
    {
        $this->validate($request, [
            'title' => 'required',
            'comment' => 'required',
            'score' => 'required',
        ], [
            'title.required'=>'عنوان ضروری است',
            'comment.required'=>'متن نظر ضروری است',
            'score.required'=>'امتیاز خود به این کالا را مشخص کنید',
        ]);
        $product=Product::where('slug',$slug)->first();

        if ($id!="") {
            $comment=Comment::find($id);
            $comment->status="Waiting";
        }else{
            $comment=new Comment();
        }
        $comment->title=$request->title;
        $comment->content=$request->comment;
        $comment->rating=$request->score;
        $comment->user_id=Auth::id();
        $comment->product_id=$product->id;
        $comment->save();
        if ($id!="") {
        session()->put('edit_comment','save_comment');
        return redirect('/profile/comments');
        }else{
            session()->put('save_comment','save_comment');
            return redirect('/product/'.$slug);
        }
    }


    public function checkout()
    {
        $user = User::find(Auth::id());

        $options = Setting::all();
        $setting = array();
        foreach ($options as $option) {
            $name = $option['setting'];
            $value = $option['value'];
            $setting[$name] = $value;
        }
        if (Auth::check()) {
            $title = "برسی و پرداخت | سوپر مارکت قزوین مرسیز";
            $seo_title = "سئو برسی و پرداخت";
            $seo_content = "سئو برسی و پرداخت";
            return view('front.shop.checkout', compact(['title', 'seo_title', 'seo_content', 'user', 'setting']));
        } else {
            return redirect('/login');
        }

    }

    public function productAttrVal()
    {
        $attribute_products = Attribute_product::all();
        $productAttrVal = [];
        foreach ($attribute_products as $row) {
            $productId = $row['product_id'];
            $attrId = $row['attribute_id'];
            $attrValueId = $row['attribute_value_id'];
            if (!isset($productAttrVal[$productId])) {
                $productAttrVal[$productId] = [];
            }
            $productAttrVal[$productId][$attrId] = $attrValueId;
        }

        return $productAttrVal;
    }

    public function doSearch(Request $request)
    {

        if ($request->slug!=""){
        if ($request->attribute) {

            $slug = $request->slug;
            $productItems = Product::whereHas('categories', function ($q) use ($slug) {
                $q->where('categories.slug', $slug);
            })->select('id')->get();
            foreach ($productItems as $item) {
                $items[] = $item->id;
            }
            $products = [];
            $attribute_product = Attribute_product::whereIn('attribute_value_id', $request->attribute)->select('product_id')->get();
            foreach ($attribute_product as $product) {
                $products[] = $product->product_id;
            }
            $attribute_products = array_intersect($products, $items);
            if (count(array_diff_assoc($attribute_products, array_unique($attribute_products)))) {
                $attribute_products = array_diff_assoc($attribute_products, array_unique($attribute_products));
            }
        } else {
            $slug = $request->slug;
            $productItems = Product::whereHas('categories', function ($q) use ($slug) {
                $q->where('categories.slug', $slug);
            })->select('id')->get();
            $attribute_products = $productItems;
        }


        if ($request->exist == "no") {
            $exist = "999999999";
            $ex = "<";
        } elseif ($request->exist == "yes") {
            $exist = "0";
            $ex = ">";
        }

        if ($request->limit) {
            $limit = $request->limit;
        } else {
            $limit = 12;
        }
        if ($request->sort) {

            if ($request->sort == "new") {
                $sort1 = 'id';
                $sort2 = 'desc';
            }
            if ($request->sort == "sale") {
                $sort1 = 'sale';
                $sort2 = 'desc';
            }
            if ($request->sort == "view") {
                $sort1 = 'view';
                $sort2 = 'desc';
            }
            if ($request->sort == "priceLow") {
                $sort1 = 'price';
                $sort2 = 'asc';
            }
            if ($request->sort == "priceHigh") {
                $sort1 = 'price';
                $sort2 = 'desc';
            }
            if ($request->sort == "discount") {
                $sort1 = 'discount';
                $sort2 = 'desc';
            }

        }

        if ($request->amount) {
            $amounts = explode('|', $request->amount);
            $min = $amounts[0];
            $max = $amounts[1];
            $min = preg_replace('/[^0-9]/', '', $min);
            $max = preg_replace('/[^0-9]/', '', $max);
        }

        $pageNum = count($attribute_products);
        $page = $limit;
        if ($pageNum >= $limit) {
            $pageNum = round($pageNum / $limit);
            $pageNum2 = $pageNum;
        } else {
            $pageNum = $limit;
            $pageNum2 = 0;

        }

        $products = Product::where([['status', 'PUBLISHED'], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->whereIn('id', $attribute_products)->orderby($sort1, $sort2)->paginate($page);
    }else{
                $exist = "999999999";
                $ex = "<";
                if ($request->exist == "yes") {
                    $exist = "0";
                    $ex = ">";
                }

                if ($request->limit) {
                    $limit = $request->limit;
                } else {
                    $limit = 12;
                }
                if ($request->sort) {

                    if ($request->sort == "new") {
                        $sort1 = 'id';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "sale") {
                        $sort1 = 'sale';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "view") {
                        $sort1 = 'view';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "priceLow") {
                        $sort1 = 'price';
                        $sort2 = 'asc';
                    }
                    if ($request->sort == "priceHigh") {
                        $sort1 = 'price';
                        $sort2 = 'desc';
                    }
                    if ($request->sort == "discount") {
                        $sort1 = 'discount';
                        $sort2 = 'desc';
                    }

                }

                if ($request->amount) {
                    $amounts = explode('|', $request->amount);
                    $min = $amounts[0];
                    $max = $amounts[1];
                    $min = preg_replace('/[^0-9]/', '', $min);
                    $max = preg_replace('/[^0-9]/', '', $max);
                }
                $all_pro_item=$productItems = Product::where('status', 'PUBLISHED')->get();
                $pageNum = count($all_pro_item);
                $page = $limit;
                if ($pageNum >= $limit) {
                    $pageNum = round($pageNum / $limit);
                    $pageNum2 = $pageNum;
                } else {
                    $pageNum = $limit;
                    $pageNum2 = 0;

                }

            $products = Product::where([['status', 'PUBLISHED'], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->orderby($sort1, $sort2)->paginate($page);

        }

        if (count($products)) {
            foreach ($products as $item) {
                $agent=new Agent();
                if ($agent->isMobile()){?>
                    <div class="d-flex align-items-right py-8" id="product"  data-page="<?= $pageNum2+1?>" style="width: 100%;text-align: right">

                        <!--product img-->
                        <a href="/product/<?= $item->slug ?>" class="d-block ml-8 p-4 position-relative" title="Link: /product/<?= $item->slug ?>">
                            <?php if($item->image){
                            if(file_exists(public_path() . '/' . $item->image)){?>
                            <img src="<?= asset($item->image) ?>" width="80" height="80" class="img-contain lazy loaded" data-src="<?= asset($item->image) ?>" alt="<?= $item->title ?>" data-was-processed="true">
                            <?php }else{ ?>
                                <img src="<?= asset('images/nopic.png') ?>" width="80" height="80" class="img-contain lazy loaded" data-src="<?= asset('images/nopic.png') ?>" alt="<?= $item->title ?>" data-was-processed="true">
                            <?php } }else{ ?>
                            <img src="<?= asset('images/nopic.png') ?>" width="80" height="80" class="img-contain lazy loaded" data-src="<?= asset('images/nopic.png')?>" alt="<?= $item->title ?>" data-was-processed="true">
                        <?php } ?>
                             <?php if ($item->discount>0){?>
                            <div class="product-box_discount"><span>%<?= $item->discount ?><small>تخفیف</small></span></div>
                             <?php } ?>
                        </a>

                        <div class="flex-grow-1">

                            <!--product title-->
                            <a href="/product/<?= $item->slug ?>" class="subtitle2 mb-16 d-block text-dark" title="Link: /product/<?= $item->slug ?>"><?= $item->title ?></a>
                            <?php if ($item->depot>0){ ?>
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                        <?php if ($item->discount>0){?>
                                    <del class="text-muted text-caption"><?= number_format($item->price) ?></del>
                                    <div class="text-primary"><?= number_format($item['price'] * (100-$item['discount']) / 100) ?> <small class="mr-4"><?= setting()['currency'] ?></small></div>
                                    <?php }else{ ?>
                                    <div class="text-primary"><?= number_format($item->price) ?><small class="mr-4"><?= setting()['currency'] ?></small></div>
                        <?php } ?>
                                </div>

                                <div class="flex-grow-0 w-100">
                                    <div class="w-100 product-box_action product-sm-box_action">
                                        <button onclick="addcart(this,'<?= $item->id ?>')" class="btn btn-gradient-primary btn-sm w-100 add-to-cart" data-supplier="False" data-qty="1"><i class="ico ico-bag d-none"></i>افزودن به سبد</button>
                                    </div>
                                </div>

                            </div>
                            <?php }else{ ?>
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                                    <div class="text-primary">تمام شد!</div>
                                </div>
                                <div class="flex-grow-0 w-100">
                                    <div class="w-100 product-box_action product-sm-box_action">
                                        <button class="btn btn-gradient-secondary btn-sm w-100 request-quantity"  data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>"  data-supplier="False"><i class="ico ico-check-circle d-none"></i>موجود کن</button>
                                    </div>
                                </div>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                <?php }else { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 p-1 " id="product"  data-page="<?= $pageNum2+1?>" style="width: 260.2px;">
                    <div class="product-box product-box_hover">

                        <!--product image and badge-->
                        <a href="/product/<?= $item->slug ?>" class="product-box_image"
                           data-click="showProductDetail" data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>"
                           data-supplier="False">
                    <?php if($item->image){
                        if(file_exists(public_path() . '/' . $item->image)){?>
                            <img src="<?= asset($item->image) ?>"
                                 alt="<?= $item->title ?>" width="210" height="210"
                                 class="swiper-lazy swiper-lazy-loaded">
                        <?php }else{ ?>
                            <img src="<?= asset('images/nopic.png') ?>"
                                 alt="<?= $item->title ?>" width="210" height="210"
                                 class="swiper-lazy swiper-lazy-loaded">
                        <?php } }else{ ?>
                        <img src="<?= asset('images/nopic.png') ?>"
                             alt="<?= $item->title ?>" width="210" height="210"
                             class="swiper-lazy swiper-lazy-loaded">
                    <?php } ?>
                            <?php if ($item->discount>0){?>
                            <div class="product-box_discount"><span>%<?= $item->discount ?><small>تخفیف</small></span></div>
                            <?php } ?>
                        </a>
                        <!--product image and badge end-->
                        <!--product title-->
                        <a href="/product/<?= $item->slug ?>" data-click="showProductDetail"
                           class="product-box_title text-dark"><h2
                                style="font-size: 0.85rem"><?= $item->title ?></h2></a>
                        <!--product title end-->
                        <!--product content-->
                        <?php if ($item->depot>0){ ?>
                        <div class="product-box_content">

                            <!--price-->
                            <a href="/product/<?= $item->slug ?>" data-click="showProductDetail"
                               data-productid="<?= $item->id ?>" class="product-box_price">
                                <?php if ($item->discount>0){?>
                                <del><?= number_format($item->price) ?></del>
                                <div class="product-box_price-value"><?= number_format($item['price'] * (100-$item['discount']) / 100) ?> <span
                                        class="product-box_price-currency"><?= setting()['currency'] ?></span></div>
                                <?php }else{ ?>
                                <div class="product-box_price-value"><?= number_format($item->price) ?> <span
                                        class="product-box_price-currency"><?= setting()['currency'] ?></span></div>
                                <?php } ?>

                            </a>

                            <!--price end-->
                            <!--action-->
                            <div class="product-box_action">
                                <button onclick="addcart(this,'<?= $item->id ?>')" type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                    به سبد
                                </button>
                            </div>
                            <!--action btn-->

                        </div>
                <?php }else{ ?>
                        <div class="product-box_content">
                            <a href="/product/<?= $item->slug ?>" data-click="showProductDetail" data-productid="<?= $item->id ?>" class="product-box_price">
                                <div class="product-box_price-value">تمام شد!</div>
                            </a>
                            <div class="product-box_action">
                                <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>" data-supplier="False">موجود کن</button>
                            </div>
                        </div>
                        <?php } ?>


                        <!--product content end-->

                    </div>
                </div>
                <?php
                }
            }
        } else {
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <h6 style="text-align: right;width: 100%">محصول مورد نظر یافت نشد!</h6>
            </div>

        <?php }


        //$productTotal=array_filter($products);

    }


    public function search_brand(Request $request)
    {
        $brand=Brand::where('link',$request->slug)->first();

        if ($request->exist == "no") {
            $exist = "999999999";
            $ex = "<";
        } elseif ($request->exist == "yes") {
            $exist = "0";
            $ex = ">";
        }

        if ($request->limit) {
            $limit = $request->limit;
        } else {
            $limit = 12;
        }
        if ($request->sort) {

            if ($request->sort == "new") {
                $sort1 = 'id';
                $sort2 = 'desc';
            }
            if ($request->sort == "sale") {
                $sort1 = 'sale';
                $sort2 = 'desc';
            }
            if ($request->sort == "view") {
                $sort1 = 'view';
                $sort2 = 'desc';
            }
            if ($request->sort == "priceLow") {
                $sort1 = 'price';
                $sort2 = 'asc';
            }
            if ($request->sort == "priceHigh") {
                $sort1 = 'price';
                $sort2 = 'desc';
            }
            if ($request->sort == "discount") {
                $sort1 = 'discount';
                $sort2 = 'desc';
            }

        }

        if ($request->amount) {
            $amounts = explode('|', $request->amount);
            $min = $amounts[0];
            $max = $amounts[1];
            $min = preg_replace('/[^0-9]/', '', $min);
            $max = preg_replace('/[^0-9]/', '', $max);
        }
        $attribute_products=Product::where(['status'=> 'PUBLISHED','brand'=>$brand->id])->get();
        $pageNum = count($attribute_products);
        $page = $limit;
        if ($pageNum >= $limit) {
            $pageNum = round($pageNum / $limit);
            $pageNum2 = $pageNum;
        } else {
            $pageNum = $limit;
            $pageNum2 = 0;

        }

        $products = Product::where([['status', 'PUBLISHED'],['brand',$brand->id], ['price', '>', $min], ['price', '<', $max], ['depot', $ex, $exist]])->orderby($sort1, $sort2)->paginate($page);


        if (count($products)) {
            foreach ($products as $item) {
                $agent=new Agent();
                if ($agent->isMobile()){?>
                    <div class="d-flex align-items-right py-8" id="product"  data-page="<?= $pageNum2+1?>" style="width: 100%;text-align: right">

                        <!--product img-->
                        <a href="/product/<?= $item->slug ?>" class="d-block ml-8 p-4 position-relative" title="Link: /product/<?= $item->slug ?>">
                            <img src="<?= asset($item->image) ?>" width="80" height="80" class="img-contain lazy loaded" data-src="<?= asset($item->image) ?>" alt="<?= $item->title ?>" data-was-processed="true">
                             <?php if ($item->discount>0){?>
                            <div class="product-box_discount"><span>%<?= $item->discount ?><small>تخفیف</small></span></div>
                             <?php } ?>
                        </a>

                        <div class="flex-grow-1">

                            <!--product title-->
                            <a href="/product/<?= $item->slug ?>" class="subtitle2 mb-16 d-block text-dark" title="Link: /product/<?= $item->slug ?>"><?= $item->title ?></a>
                            <?php if ($item->depot>0){ ?>
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                        <?php if ($item->discount>0){?>
                                    <del class="text-muted text-caption"><?= number_format($item->price) ?></del>
                                    <div class="text-primary"><?= number_format($item['price'] * (100-$item['discount']) / 100) ?> <small class="mr-4"><?= setting()['currency'] ?></small></div>
                                    <?php }else{ ?>
                                    <div class="text-primary"><?= number_format($item->price) ?><small class="mr-4"><?= setting()['currency'] ?></small></div>
                        <?php } ?>
                                </div>

                                <div class="flex-grow-0 w-100">
                                    <div class="w-100 product-box_action product-sm-box_action">
                                        <button onclick="addcart(this,'<?= $item->id ?>')" class="btn btn-gradient-primary btn-sm w-100 add-to-cart" data-supplier="False" data-qty="1"><i class="ico ico-bag d-none"></i>افزودن به سبد</button>
                                    </div>
                                </div>

                            </div>
                            <?php }else{ ?>
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="line-height-sm w-100 flex-grow-1 font-weight-bold">
                                    <div class="text-primary">تمام شد!</div>
                                </div>
                                <div class="flex-grow-0 w-100">
                                    <div class="w-100 product-box_action product-sm-box_action">
                                        <button class="btn btn-gradient-secondary btn-sm w-100 request-quantity"  data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>"  data-supplier="False"><i class="ico ico-check-circle d-none"></i>موجود کن</button>
                                    </div>
                                </div>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                <?php }else { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 p-1 " id="product"  data-page="<?= $pageNum2+1?>" style="width: 260.2px;">
                    <div class="product-box product-box_hover">

                        <!--product image and badge-->
                        <a href="/product/<?= $item->slug ?>" class="product-box_image"
                           data-click="showProductDetail" data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>"
                           data-supplier="False">
                            <img src="<?= asset($item->image) ?>"
                                 alt="<?= $item->title ?>" width="210" height="210"
                                 class="swiper-lazy swiper-lazy-loaded">
                            <?php if ($item->discount>0){?>
                            <div class="product-box_discount"><span>%<?= $item->discount ?><small>تخفیف</small></span></div>
                            <?php } ?>
                        </a>
                        <!--product image and badge end-->
                        <!--product title-->
                        <a href="/product/<?= $item->slug ?>" data-click="showProductDetail"
                           class="product-box_title text-dark"><h2
                                style="font-size: 0.85rem"><?= $item->title ?></h2></a>
                        <!--product title end-->
                        <!--product content-->
                        <?php if ($item->depot>0){ ?>
                        <div class="product-box_content">

                            <!--price-->
                            <a href="/product/<?= $item->slug ?>" data-click="showProductDetail"
                               data-productid="<?= $item->id ?>" class="product-box_price">
                                <?php if ($item->discount>0){?>
                                <del><?= number_format($item->price) ?></del>
                                <div class="product-box_price-value"><?= number_format($item['price'] * (100-$item['discount']) / 100) ?> <span
                                        class="product-box_price-currency"><?= setting()['currency'] ?></span></div>
                                <?php }else{ ?>
                                <div class="product-box_price-value"><?= number_format($item->price) ?> <span
                                        class="product-box_price-currency"><?= setting()['currency'] ?></span></div>
                                <?php } ?>

                            </a>

                            <!--price end-->
                            <!--action-->
                            <div class="product-box_action">
                                <button onclick="addcart(this,'<?= $item->id ?>')" type="button" class="btn btn-gradient-primary add-to-cart pr-8 pl-8"><i class="ico ico-color_plus-circle filter-none"></i>افزودن
                                    به سبد
                                </button>
                            </div>
                            <!--action btn-->

                        </div>
                <?php }else{ ?>
                        <div class="product-box_content">
                            <a href="/product/<?= $item->slug ?>" data-click="showProductDetail" data-productid="<?= $item->id ?>" class="product-box_price">
                                <div class="product-box_price-value">تمام شد!</div>
                            </a>
                            <div class="product-box_action">
                                <button type="button" class="btn btn-gradient-secondary request-quantity" data-productid="<?= $item->id ?>" data-storeid="<?= $item->id ?>" data-supplier="False">موجود کن</button>
                            </div>
                        </div>
                        <?php } ?>


                        <!--product content end-->

                    </div>
                </div>
                <?php
                }
            }
        } else {
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <h6 style="text-align: right;width: 100%">محصول مورد نظر یافت نشد!</h6>
            </div>

        <?php }


        //$productTotal=array_filter($products);

    }

    public function spacial()
    {
        $spacial_discount = Product::where(['status'=> 'PUBLISHED','special'=>'YES'])->where('discount', '!=', '0')->orderby('discount','Desc')->take(7)->get();
        $spacials = Product::where(['status'=> 'PUBLISHED','special'=>'YES'])->paginate(16);
        $title = "محصولات شگفت انگیز | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو محصولات شگفت انگیز";
        $seo_content = "سئو محصولات شگفت انگیز";
        return view('front.spacial.index', compact('title', 'seo_title', 'seo_content',  'spacial_discount','spacials'));
    }

    public function about()
    {
        $about=About::find(1);
        $title = "درباره ما | سوپر مارکت قزوین مرسیز";
        $seo_title = "سئو درباره ما";
        $seo_content = "سئو درباره ما";
        return view('front.about.index', compact('title', 'seo_title', 'seo_content',  'about'));
    }

    public function contact_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'message' => 'required',

        ], [
            'name.required' => 'فیلد نام نمی تواند خالی باشد',
            'mobile.required' => 'فیلد شماره موبایل خالی باشد',
            'mobile.digits' => 'شماره موبایل نادرست است',
            'mobile.regex' => 'شماره موبایل نادرست است',
            'email.required' => 'فیلد ایمیل نمی تواند خالی باشد',
            'email.email' => 'ایمیل نادرست است',
            'message.required' => 'فیلد متن نمی تواند خالی باشد',

        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->message = $request->message;
        $contact->mobile = $request->mobile;
        $contact->email = $request->email;
        $contact->save();
        session()->put('save_comment', 'پیام شما با موفقیت ارسال شد!');
        return redirect()->back();
    }

    public function newslater_create(Request $request)
    {
        $club = new Club();
        $club->email = $request->email;
        $club->mobile = $request->mobile;
        $club->save();
        session()->put('save_newslater', 'ایمیل شما با موفقیت ثبت شد!');
        return redirect('/');
    }

    public function apiGetProducts($slug = "")
    {

        $category = Category::where('slug', $slug)->first();
        $catId = $category->id;
        $products = Product::whereHas('categories', function ($q) use ($slug) {
            $q->where('categories.slug', $slug);
        })->where('status', 'PUBLISHED')->paginate(4);

        $attributes = Attribute::with('attribute_values')->whereHas('categories', function ($q) use ($catId) {
            $q->where('categories.id', $catId);
        })->where('inshop', 'YES')->get();

        return response()->json([
            'products' => $products,
            'attributes' => $attributes
        ]);


    }

    public function search($slug = "")
    {
        //$productAttrVal = $this->productAttrVal();
        $sort = $_GET['sort'];
        if ($sort != "") {

            if ($sort == "new") {
                $sort1 = 'id';
                $sort2 = 'desc';
            }
            if ($sort == "sell") {
                $sort1 = 'sale';
                $sort2 = 'desc';
            }
            if ($sort == "view") {
                $sort1 = 'view';
                $sort2 = 'desc';
            }
            if ($sort == "sale") {
                $sort1 = 'sale';
                $sort2 = 'desc';
            }
            if ($sort == "discount") {
                $sort1 = 'discount';
                $sort2 = 'desc';
            }
            if ($sort == "priceLow") {
                $sort1 = 'price';
                $sort2 = 'asc';
            }
            if ($sort == "priceHigh") {
                $sort1 = 'price';
                $sort2 = 'desc';
            }

        }
        $minamount = 0;
        $maxamount = 500000000;
        if ($_GET['priceFiltter']) {
            $priceFiltter = explode($_GET['priceFiltter'], '|');
            $minamount = $priceFiltter[0];
            $maxamount = $priceFiltter[1];
        }

        return response()->json([
            'products' => $_GET['priceFiltter']
        ]);
        $products = Product::where([['status', 'PUBLISHED'], ['price', '>', $minamount], ['price', '<', $maxamount]])->orderby($sort1, $sort2)->paginate(20);
        return response()->json([
            'products' => $products
        ]);
    }



    public function apiGetFilterProduct($slug = "", $sort = "", $paginate = "", $attributes = [])
    {
        $attributesArray = json_decode($attributes, true);

        $products = Product::whereHas('categories', function ($q) use ($slug) {
            $q->where('categories.slug', $slug);
        })->whereHas('attribute_products', function ($q) use($attributesArray){
            $q->whereIn('attribute_products.attribute_value_id', $attributesArray);
        })->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function page($slug){
        $page=Page::where(['slug'=>$slug,'status'=>'PUBLISHED'])->first();
        $title = $page->title;
        $seo_title = $page->seoTitle;
        $seo_content =$page->seoContent;
        return view('front.page.index', compact('title', 'seo_title', 'seo_content', 'page'));
    }
}
