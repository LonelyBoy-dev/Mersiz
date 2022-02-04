<?php

namespace App\Http\Controllers\Front;

use App\Address;
use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use App\Gallery;
use App\Post;
use App\Slider;
use App\Order;
use App\Product;
use App\Banner;
use App\Favorite;
use App\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ApiController extends Controller
{

    public function getSliders()
    {
        $result = Slider::where('status', 'Show')->get();
        return  $result;
    }

    public function getBanners()
    {
        $result = Banner::where(['status' => 'show'])->inRandomOrder()->get();
        return  $result;
    }

    public function getBrands()
    {
        $result = Brand::where(['status' => 'show'])->get();
        return  $result;
    }

    public function getPostsIndex()
    {
        $result = Post::where('status', 'PUBLISHED')->with('postcategories')->orderby('id', 'desc')->take(10)->get();
        return  $result;
    }


    public function registerMobile(Request $request)
    {

        // return response()->json([
        //     'mobile' => $request->mobile
        // ], 201);



        $code = rand(1000, 9999);

        $this->validate(
            $request,
            [
                'mobile' => 'required|digits:11|regex:/(09)[0-9]{9}/|numeric',
            ],
            [
                'mobile.digits' => ' شماره موبایل باید 11 رقم باشد.',
                'mobile.required' => 'شماره موبایل را وارد کنید.',
                'mobile.regex' => 'فرمت شماره موبایل صحیح نیست.',
                'mobile.numeric' => 'لطفا مقدار عددی وارد کنید.',
            ]
        );

        $mobile = $request->mobile;
        $users = User::where('mobile', $mobile)->first();
        if (empty($users)) {
            $user = new User();
            $user->mobile = $mobile;
            $user->verifire_code = $code;
            $user->save();

            /*============= sms =============*/
            $username = trim(setting()['username_sms']);
            $password = trim(setting()['password_sms']);
            $from = "+983000505";
            $pattern_code = "u5550aipad";
            $to = array($mobile);
            $input_data = array("verification-code" => $code);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            /*============= sms =============*/

            session()->put('rmobile', $mobile);
            return response()->json([
                'msg' => 'verify'
            ], 201);
            // return redirect()->route('verify');
        } else {
            if ($users->statusregister == 1) {
                return response()->json([
                    'msg' => 'login'
                ]);
                // return redirect()->to('/login');
            } else {
                $users->verifire_code = $code;
                $users->save();

                /*============= sms =============*/
                $username = trim(setting()['username_sms']);
                $password = trim(setting()['password_sms']);
                $from = "+983000505";
                $pattern_code = "u5550aipad";
                $to = array($mobile);
                $input_data = array("verification-code" => $code);
                $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($handler);
                /*============= sms =============*/

                session()->put('rmobile', $mobile);
                return response()->json([
                    'msg' => 'verify'
                ], 201);

                // return redirect()->route('verify');
            }
        }
    }


    public function registerCode(Request $request)
    {
       
        $usermobile = $request->mobile;
        $user = User::where('mobile', $usermobile)->first();

        if ($request->code == $user->verifire_code) {
           
            $user->verifire = 'YES';
            $user->status = 'ACTIVE';
            $user->save();

            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;


            return response()->json([
                'msg' => 'registerCode',
                'token' => $token
            ], 201);
        } else {
            return response()->json([
                'msg' => 'notcode'
            ], 422);
        }
    }


    public function infoUser(Request $request)
    {

        return response()->json([
            'msg' => 'registerCode',
            'infoUser' => $request->user()
        ], 201);
    }

    public function updateUser(Request $request)
    {

        $id = $request->user()->id;
        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->family = $request->family;
        $user->address = $request->address;
        $user->save();

        return response()->json([
            'msg' => 'infoUpdate',
        ], 201);
    }


    public function addAddress(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'plaque' => 'required',
        ], []);
        if ($request->status == "insert") {
            $address = new Address();
            $address->user_id = Auth::id();
            $address->name = $request->name;
            $address->mobile = $request->mobile;
            $address->address = $request->address;
            $address->plaque = $request->plaque;
            $address->location = $request->Map;
            $address->unit = $request->unit;
            $address->postal_code = $request->postalcode;
            if ($request->back_url) {
                Address::where('user_id', Auth::id())->update(['selected' => "NO"]);
                $address->selected = "YES";
            }
            $address->save();
            session()->put('save_address', 'آدرس جدید با موفقیت ثبت شد');
        } elseif ($request->status == "update") {
            $address = Address::where(['user_id' => Auth::id(), 'id' => $request->data_id])->first();
            $address->name = $request->name;
            $address->mobile = $request->mobile;
            $address->address = $request->address;
            $address->plaque = $request->plaque;
            $address->location = $request->Map;
            $address->unit = $request->unit;
            $address->postal_code = $request->postalcode;
            $address->save();
            session()->put('save_address_update', 'آدرس شما با موفقیت ویرایش شد');
        }

        return response()->json([
            'msg' => 'address-success',
        ], 201);
    }

    public function getAddress(Request $request)
    {

        $user_id = $request->user()->id;
        $address =  Address::where('user_id', $user_id)->orderby('id', 'desc')->get();

        if (!empty($address->all())) {
            return $address;
        } else {
            return "nodata";
        }
    }

    public function getCategory()
    {
        $result = Category::orderby('id', 'desc')->get();
        return $result;
    }

    public function getCategoryImage()
    {
        $result = Category::where('showindex', '!=', 'NO')->orderby('id', 'desc')->get();
        return $result;
    }

    public function getCategoryProduct()
    {
        // $result = Category::with('products','products.features')->where('showindex','!=', 'NO')->orderby('id','desc')->get();
        // foreach ($result as $item) {
        //     $products = [];
        //     $features = [];
        //     for ($i = 0; $i < count($item->products); $i++) {

        //         if ($item->products[$i]->status == "PUBLISHED" and $item->products[$i]->day_basket!='YES') {
        //             $products[] = $item->products[$i];

        //         }

        //         if(count($products) == 10){
        //             break;
        //         }

        //     }
        //     $item->unsetRelation('products');
        //     $item->products = $products;

        // }

        $result = Category::where('showindex', '!=', 'NO')->orderby('id', 'desc')->get();
        return $result;
    }

    public function getProducts($categoryId)
    {
        $result = Category::with('products')->where('id', $categoryId)->orderby('id', 'desc')->first();
        // $result = Product::where('status', 'PUBLISHED')->with('features')->orderby('id','desc')->get();
        return $result->products;
    }

    public function getProduct($id)
    {
        $result = Product::where('id', $id)->orderby('id', 'desc')->first();
        return $result;
    }

    public function getCategoryProductsPage()
    {
        $product_category = Prcategory::where('category_page', 1)->limit(10)->get();
        foreach ($product_category as $item) {
            $categories = Prcategory::with('products')->where('parent', $item->id)->inRandomOrder()->get();
            foreach ($categories as $cat) {
                $cat->totalproduct = count($cat->products);
            }
            $item->categories = $categories;
        }
        return $product_category;
    }

    public function getDayBasketProduct()
    {
        $result = Product::where('status', 'PUBLISHED')->where('day_basket', 'YES')->orderby('discount', 'Desc')->take(8)->get();
        return $result;
    }
    public function getDiscountProduct()
    {
        $result = Product::where('status', 'PUBLISHED')->where('discount', '!=', '0')->where('day_basket', 'NO')->orderby('discount', 'Desc')->take(12)->get();
        return $result;
    }

    public function getGalleryProducts($id)
    {
        $result = Gallery::where('product_id', $id)->get();
        return  $result;
    }

    public function getNewProducts($id)
    {
        $result = Category::where('id', $id)->with(['products' => function ($query) {
            $query->where('status', 'PUBLISHED')->orderby('id', 'desc')->get();
        }])->first();

        return $result;
    }

    public function getViewProducts($id)
    {
        $result = Category::where('id', $id)->with(['products' => function ($query) {
            $query->where('status', 'PUBLISHED')->orderby('view', 'desc')->take(10)->get();
        }])->first();

        return $result;
    }

    public function SendViewProduct(Request $request)
    {
        $ipuser = Ipuser::where(['ip' => $request->ip, 'product_id' => $request->id])->first();
        if (empty($ipuser)) {
            $ip = new Ipuser();
            $ip->ip = $request->ip;
            $ip->product_id = $request->id;
            $ip->save();
            $product = Product::where('id', $request->id)->first();
            $product->visitor = $product->visitor + 1;
            $product->view = $product->view + 1;
            $product->save();
        } else {
            $product = Product::where('id', $request->id)->first();
            $product->view = $product->view + 1;
            $product->save();
        }
    }

    public function Favorite(Request $request)
    {
        $user_id = $request->user()->id;
        $product_id = $request->id;
        $favorite = new Favorite();
        $favorite->product_id = $product_id;
        $favorite->user_id = $user_id;
        $favorite->save();
    }

    public function FavoriteRemove(Request $request)
    {
        $user_id = $request->user()->id;
        $product_id = $request->id;
        $favorite = Favorite::where(['user_id' => $user_id, 'product_id' => $product_id])->delete();
    }

    public function CheckFavorite(Request $request)
    {
        $user_id = $request->user()->id;
        $product_id = $request->id;
        $favorite = Favorite::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        if (!empty($favorite)) {
            return 'Isfavorite';
        }
    }

    public function getFavorite(Request $request)
    {
        $user_id = $request->user()->id;
        $favorites = Favorite::where('user_id', $user_id)->get();
        if (!empty($favorites->all())) {
            foreach ($favorites as $favorite) {
                $products[] = Product::with('features')->where('id', $favorite->product_id)->first();
            }
            return $products;
        } else {
            return "nodata";
        }
    }

    public function getLikeProducts($id)
    {
        $product = Product::with('categories')->where('id', $id)->first();

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

        return $like_products;
    }
}
