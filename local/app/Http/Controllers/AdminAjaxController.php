<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Attribute_category;
use App\Attribute_product;
use App\Attribute_value;
use App\Balanceprice;
use App\Banner;
use App\Brand;
use App\News;
use App\Category;
use App\Club;
use App\Commission_sale;
use App\Complain;
use App\Contact;
use App\Directselling;
use App\Discountcode;
use App\Faq;
use App\Feature;
use App\Message;
use App\Model\Postcategories;
use App\Order;
use App\Package;
use App\Page;
use App\Payment;
use App\Product;
use App\Proposalimage;
use App\Request_quantity;
use App\Slider;
use App\User;
use App\Alert;
use App\Role_user;
use App\Role;
use App\Permission_role;
use App\Wallet;
use App\Tree;
use App\Walletsreport;
use App\Post;
use App\Postcategory;
use App\Gallery;
use App\Comment;
use App\Commentminiproducts;
use App\Offcode;
use App\Miniproduct;
use Cookie;
use DB;
use App\Post_comments;
use Hekmatinasser\Verta\Verta;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAjaxController extends Controller
{
    public function number_format_price(Request $request)
    {
        echo number_format($request->price);
    }

    public function get_user_reference(Request $request)
    {
        $token = $request->input('value');
        $wallet = Tree::where('reference_code', $token)->first();
        if ($wallet) {

            $user = User::find($wallet->user_id);
            if ($user) {
                session()->put('check_token_wallet', $token);
                return response()->json([
                    "name" => $user->name,
                ]);
            } else {
                echo 'notok';
            }
        } else {
            echo 'notok';
        }

    }
    public function check_token_wallet(Request $request)
    {
        $token = $request->input('token');
        $wallet = Wallet::where('token', $token)->first();
        if ($wallet) {
            if ($wallet->user_id != Auth::id()) {
                $user = User::find($wallet->user_id);
                if ($user) {
                    session()->put('check_token_wallet', $token);
                    return response()->json([
                        "name" => $user->name,
                    ]);
                } else {
                    echo 'notok';
                }

            } else {
                echo 'notok';
            }

        } else {
            echo 'notok';
        }

    }

    public function check_pass_wallet(Request $request)
    {
        $user = User::findorfail(Auth::id());
        if (password_verify($request->password, $user->password)) {
            echo 'ok';
        } else {
            echo 'notok';
        }
    }

    public function check_mobile_wallet(Request $request)
    {
        $user = User::findorfail(Auth::id());
        if ($request->mobile == $user->mobile) {
            $code = rand(100000, 999999);
            $username = "udreams";
            $password = 'fardabia20002000';
            $from = "+983000505";
            $pattern_code = "30a206hbb9";
            $to = array($request->input('mobile'));
            $input_data = array("verification-code" => $code);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            $user->verifire_code = $code;
            $user->save();
        } else {
            echo 'no-mobil';
        }
    }

    public function check_code_wallet(Request $request)
    {
        $user = User::findorfail(Auth::id());
        if ($request->code == $user->verifire_code) {
            echo 'ok';
        } else {
            echo 'notok';
        }
    }

    public function check_answer_wallet(Request $request)
    {
        $user = User::findorfail(Auth::id());
        if ($request->answer == $user->answer) {
            echo 'ok';
        } else {
            echo 'notok';
        }
    }

    public function send_price_wallet(Request $request)
    {
        if ($request->price>=1000){
            if ($request->price<=50000000){
                $token = session()->get('check_token_wallet');
                $wallet = Wallet::where('token', $token)->first();
                if ($wallet) {
                    if ($wallet->user_id != Auth::id()) {
                        $user = User::find($wallet->user_id);
                        if ($user) {
                            $user_wallet = Wallet::where('user_id', Auth::id())->first();
                            if ($user_wallet->price >= $request->price) {
                                $user_wallet->price = $user_wallet->price - $request->price;
                                $user_wallet->save();


                                $wallet->price = $wallet->price + $request->price;
                                $wallet->save();


                                $walletsreport = new Walletsreport();
                                $walletsreport->user_id = Auth::id();
                                $walletsreport->wallet_id = $user_wallet->id;
                                $walletsreport->description = "انتقال پول به " . $user->name;
                                $walletsreport->price = $request->price;
                                $walletsreport->desprice = $request->des_price;
                                $walletsreport->status = "PAY";
                                $walletsreport->save();


                                $username = "udreams";
                                $password = 'fardabia20002000';
                                $from = "+983000505";
                                $pattern_code = "86fy05dqj0";
                                $to = array(Auth::user()->mobile);
                                $date = Verta::now();
                                $input_data = array("name" => Auth::user()->name,"price"=>$request->price,"namee"=>$user->name,"date"=>$date);
                                $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
                                $handler = curl_init($url);
                                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($handler);


                                session()->put('send_price_wallet_success', 'با موفقیت انتقال یافت');
                                echo '/adminb/wallet';

                            } else {
                                echo 'nomony';
                            }

                        }else{
                            echo 'notok';
                        }
                    }else{
                        echo 'notok';
                    }
                }else{
                    echo 'notok';
                }
            }else{
                echo 'maximum';
            }

        }else{
            echo 'minimum';
        }


    }

    public function check_return_code_wallet(Request $request)
    {
        $user = User::findorfail(Auth::id());
        if ($request->mobile == $user->mobile) {
            $code = rand(100000, 999999);
            $username = "udreams";
            $password = 'fardabia20002000';
            $from = "+983000505";
            $pattern_code = "30a206hbb9";
            $to = array($request->input('mobile'));
            $input_data = array("verification-code" => $code);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            $user->verifire_code = $code;
            $user->save();
        } else {
            echo 'no-mobil';
        }
    }

    public function Money_transfer_wallet(Request $request)
    {
        $status = $request->status;
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $pay = 'no';
        if ($status == 'direct') {
            $direct = Directselling::where('user_id', Auth::id())->first();
            if ($direct and $direct->price!=0) {

                $walletsreport = new Walletsreport();
                $walletsreport->user_id = Auth::id();
                $walletsreport->price = $direct->price;
                $walletsreport->description = "واریزی از بودجه آموزش یار";
                $walletsreport->status = "PAY";
                $walletsreport->wallet_id = $wallet->id;
                $walletsreport->save();

                $wallet->price = $wallet->price + $direct->price;
                $wallet->total_price = $wallet->total_price + $direct->price;
                $wallet->save();
                $direct->price=0;
                $direct->save();
                $pay = 'yes';
            }
        }
        if ($status == "balance") {
            $balance = Balanceprice::where('user_id', Auth::id())->first();
            if ($balance and $balance->price!=0) {

                $walletsreport = new Walletsreport();
                $walletsreport->user_id = Auth::id();
                $walletsreport->price = $balance->price;
                $walletsreport->description = "واریزی از بودجه آموزشی";
                $walletsreport->status = "PAY";
                $walletsreport->wallet_id = $wallet->id;
                $walletsreport->save();


                $store_sponsor = $balance->price * 10 / 100;
                /*$price=$balance->price - $store_sponsor;*/
                $price=$balance->price ;

                /*$wallet->price = $wallet->price + $price;*/
                $wallet->price = $wallet->price + $price;
                /*$wallet->store_sponsor = $store_sponsor+$store_sponsor;*/
                $wallet->store_sponsor = 0;
                $wallet->total_price = $wallet->total_price + $price;
                $wallet->save();
                $balance->price=0;
                $balance->save();
                $pay = 'yes';
            }

        }
        if ($status == 'sell') {
            $commission_sale = Commission_sale::where('user_id', Auth::id())->first();
            if ($commission_sale and $commission_sale->price!=0) {

                $walletsreport = new Walletsreport();
                $walletsreport->user_id = Auth::id();
                $walletsreport->price = $commission_sale->price;
                $walletsreport->description = "واریزی از پورسانت فروش";
                $walletsreport->status = "PAY";
                $walletsreport->wallet_id = $wallet->id;
                $walletsreport->save();

                $wallet->price = $wallet->price + $commission_sale->price;
                $wallet->total_price = $wallet->total_price + $commission_sale->price;
                $wallet->save();
                $commission_sale->price=0;
                $commission_sale->save();
                $pay = 'yes';
            }
        }
        return response()->json([
            'price' => number_format($wallet->price),
            'total_price' => number_format($wallet->total_price),
            'pay' => $pay,
        ]);
    }


    public function selfupdateuser(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
//                'homename' => 'required|string|max:255|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
//                'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
//                'melicode' => 'required|digits:10|numeric',
                'ostan' => 'required',
                'city' => 'required',
//                'username' => 'required|string|max:255|min:3|regex:/^[A-Za-z][A-Za-z0-9]*$/|unique:users',
//                'password' => 'required|string|min:7|confirmed',
            ],
            [
//                'password.min' => 'رمز عبور باید حداقل 7 کاراکتر باشد.',
//                'password.confirmed' => 'رمز عبور وارد شده یکسان نیست.',
//                'username.unique' => 'این نام کاربری از قبل وجود دارد.',
                'name.required' => 'نام و نام خانوادگی را وارد کنید.',
                'name.regex' => 'نام و نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
//                'username.required' => 'نام کاربری را وارد کنید.',
//                'password.required' => 'رمز عبور را وارد کنید.',
                'name.min' => ' نام و نام خانوادگی باید حداقل 3 کاراکتر باشد.',
//                'username.min' => ' نام کاربری باید حداقل 3 کاراکتر باشد.',
//                'username.regex' => ' نام کاربری باید به صورت لاتین وارد شود.',
//                'mobile.digits' => ' شماره موبایل باید 11 رقم باشد.',
//                'mobile.required' => 'شماره موبایل را وارد کنید.',
//                'mobile.regex' => 'فرمت شماره موبایل صحیح نیست.',
//                'mobile.numeric' => 'لطفا مقدار عددی وارد کنید.',
//                'melicode.numeric' => 'لطفا مقدار عددی وارد کنید.',
//                'melicode.required' => 'کد ملی را وارد کنید.',
//                'melicode.digits' => ' کد ملی باید 10 رقم باشد.',
                'ostan.required' => ' استان خود را انتخاب کنید',
                'city.required' => ' شهر خود را انتخاب کنید',
            ]
        );

        $user = User::findorfail(Auth::id());
        $user->name = $request->name;
        $user->sex = $request->sex;
        $user->ostan = $request->ostan;
        $user->ostan_id = $request->ostan_id;
        $user->city_id = $request->city_id;
        $user->save();


        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function Change_status_user(Request $request)
    {
        $user=User::findorfail($request->user_id);
        $user->status=$request->status;
        $user->save();
        if ($request->status=="ACTIVE"){
            echo 'ACTIVE';
        }else{
            echo 'INACTIVE';
        }

    }

    public function Change_status_user_wallet(Request $request)
    {
        $user=User::findorfail($request->user_id);
        $user->wallet_status=$request->status;
        $user->save();
        if ($request->status=="ACTIVE"){
            echo 'ACTIVE';
        }else{
            echo 'INACTIVE';
        }

    }

    public function Change_status_user_sendmoney(Request $request)
    {
        $user=User::findorfail($request->user_id);
        $user->sendmoney_status=$request->status;
        $user->save();
        if ($request->status=="ACTIVE"){
            echo 'ACTIVE';
        }else{
            echo 'INACTIVE';
        }

    }

    public function Change_status_user_seller(Request $request)
    {
        $user=User::findorfail($request->user_id);
        $user->seller=$request->status;
        $user->save();
        if ($request->status=="YES"){
            echo 'ACTIVE';
        }else{
            echo 'INACTIVE';
        }

    }

    public function uploadimageprofile(Request $request)
    {
        if(isset($request->id)){
            $user = User::findorfail($request->id);

            if(!empty($user->avatar)){
                if(file_exists(public_path($user->avatar))){
                    unlink(public_path($user->avatar));
                }
            }
            $file = $request->file('file');
            $image = Image::make($file);
            //save image
            $name = time() .rand(). $file->getClientOriginalName() ;
            $image->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/user_profile/' . $user->id)){
                mkdir("images/user_profile/". $user->id);
            }
            $image->save('images/user_profile/' .$user->id .'/'. $name);


            /*                $file->move('images/user_profile/' . $request->id , $name);*/
            $user->avatar = 'images/user_profile/' . $user->id . '/' . $name;
            $user->save();

            return response()->json([
                'status' => asset($user->avatar)
            ]);

        }else{
            $user = User::findorfail(Auth::id());

            if(!empty($user->avatar)){
                if(file_exists(public_path($user->avatar))){
                    unlink(public_path($user->avatar));
                }
            }

            $file = $request->file('file');
            $image = Image::make($file);
            //save image
            $name = time() .rand(). $file->getClientOriginalName() ;
            $image->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/user_profile/' . $user->id)){
                mkdir("images/user_profile/". $user->id);
            }
            $image->save('images/user_profile/' .$user->id .'/'. $name);


            /*                $file->move('images/user_profile/' . $request->id , $name);*/
            $user->avatar = 'images/user_profile/' . $user->id . '/' . $name;
            $user->save();

            return response()->json([
                'status' => asset($user->avatar)
            ]);

        }

    }


    public function Change_documents_user(Request $request)
    {
        if(isset($request->id)){
            if ($request->filetype=="meli"){
                $user = User::findorfail($request->id);

                if(!empty($user->image_meli)){
                    if(file_exists(public_path($user->image_meli))){
                        unlink(public_path($user->image_meli));
                    }
                }

                $file = $request->file('file');

                $image = Image::make($file);
                //save image
                $name = time() .rand(). $file->getClientOriginalName() ;
                $image->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(!is_dir('images/user_profile/' . $user->id)){
                    mkdir("images/user_profile/". $user->id);
                }
                $image->save('images/user_profile/' .$user->id .'/'. $name);


                /*                $file->move('images/user_profile/' . $request->id , $name);*/
                $user->image_meli = 'images/user_profile/' . $user->id . '/' . $name;
                $user->save();

                return response()->json([
                    'status' => asset($user->image_meli)
                ]);

            }else{

                $user = User::findorfail($request->id);

                if(!empty($user->image_certificate)){
                    if(file_exists(public_path($user->image_certificate))){
                        unlink(public_path($user->image_certificate));
                    }
                }

                $file = $request->file('file');

                $image = Image::make($file);
                //save image
                $name = time() .rand(). $file->getClientOriginalName() ;
                $image->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(!is_dir('images/user_profile/' . $user->id)){
                    mkdir("images/user_profile/". $user->id);
                }
                $image->save('images/user_profile/' .$user->id .'/'. $name);


                /*                $file->move('images/user_profile/' . $request->id , $name);*/
                $user->image_certificate = 'images/user_profile/' . $user->id . '/' . $name;
                $user->save();

                return response()->json([
                    'status' => asset($user->image_certificate)
                ]);
            }

        }else{

            $user = User::findorfail(Auth::id());
            if ($request->filetype=="meli"){

                if(!empty($user->image_meli)){
                    if(file_exists(public_path($user->image_meli))){
                        unlink(public_path($user->image_meli));
                    }
                }

                $file = $request->file('file');

                $image = Image::make($file);
                //save image
                $name = time() .rand(). $file->getClientOriginalName() ;
                $image->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(!is_dir('images/user_profile/' . $user->id)){
                    mkdir("images/user_profile/". $user->id);
                }
                $image->save('images/user_profile/' .$user->id .'/'. $name);


                /*                $file->move('images/user_profile/' . $request->id , $name);*/
                $user->image_meli = 'images/user_profile/' . $user->id . '/' . $name;
                $user->documents_status="Waiting";
                $user->save();

                return response()->json([
                    'status' => asset($user->image_meli)
                ]);

            }else{



                if(!empty($user->image_certificate)){
                    if(file_exists(public_path($user->image_certificate))){
                        unlink(public_path($user->image_certificate));
                    }
                }

                $file = $request->file('file');

                $image = Image::make($file);
                //save image
                $name = time() .rand(). $file->getClientOriginalName() ;
                $image->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(!is_dir('images/user_profile/' . $user->id)){
                    mkdir("images/user_profile/". $user->id);
                }
                $image->save('images/user_profile/' .$user->id .'/'. $name);


                /*                $file->move('images/user_profile/' . $request->id , $name);*/
                $user->image_certificate = 'images/user_profile/' . $user->id . '/' . $name;
                $user->documents_status="Waiting";
                $user->save();

                return response()->json([
                    'status' => asset($user->image_certificate)
                ]);
            }

        }

    }


    public function getstate(Request $request){

        /********** city **********/
        $content = json_decode(file_get_contents(public_path('js/frotel/city.json')));
        foreach ($content as $val){
            if($val->name == $request->state){
                $citys = $val->cities;
            }
        }
        foreach ($citys as $val){
            $city[$val->name] = $val->name;
        }
        /********** city **********/

        return $city;
    }

    function Change_documents_status_user(Request $request)
    {
        $user= User::findorfail($request->user_id);
        $table=$request->profile;
        $user->$table=$request->status;
        if (!empty($request->rejection_documents)){
            $user->rejection_documents=$request->rejection_documents;
        }
        if (!empty($request->rejection_profile)){
            $user->rejection_profile=$request->rejection_profile;
        }
        $user->save();

        if ($request->status=="Confirmation"){
            echo "ok";
        }elseif ($request->status=="disapproval"){
            echo "notok";
        }

    }

    public function Change_user_isadmin(Request $request)
    {
        if ($request->admin=="admin"){
            $Role_user=new Role_user();
            $Role_user->user_id=$request->user_id;
            $Role_user->role_id=$request->user_id;
            $Role_user->save();

            $user=User::findorfail($request->user_id);
            $user->role=$request->user_id;
            $user->save();

            $roles=new Role();
            $roles->id=$request->user_id;
            $roles->name='کاربر انتخابی';
            $roles->save();
            echo 'admin';
        }
        elseif($request->admin=="notadmin"){
            $Role_user=Role_user::where('user_id',$request->user_id)->first();
            $Role_user->delete();
            $user=User::findorfail($request->user_id);
            $user->role=0;
            $user->save();

            Role::where('id',$request->user_id)->delete();

            Permission_role::where('user_id',$request->user_id)->delete();
            echo 'delete';
        }
    }

    public function alert_status(Request $request)
    {
        $alert=Alert::where('id',$request->alert_id)->first();
        $alert->status=$request->status;
        $alert->save();
        echo $request->status;
    }

    public function alert_remove(Request $request)
    {
        Alert::where('id',$request->alert_id)->delete();
        echo 'delete';
    }

    public function delete_news(Request $request)
    {
        News::where('id',$request->id)->delete();
        echo 'delete';
    }


    public function change_status_news(Request $request)
    {
        News::where('id',$request->id)->update(['status'=>$request->status]);
        echo 'ok';
    }

    public function delete_post(Request $request)
    {
        $post = Post::findorfail($request->id);
        if(file_exists(public_path() . '/' . $post->imgPath)){
            unlink(public_path() . '/' . $post->imgPath);
        }
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_posts(Request $request)
    {

        foreach ($request->selectedLanguage as $delete) {
            $post = Post::findorfail($delete);
            if(file_exists(public_path() . '/' . $post->imgPath)){
                unlink(public_path() . '/' . $post->imgPath);
            }
            if ($post->delete()) {
                echo 'deleted';
            } else {
                echo 'Notdeleted';
            }
        }

    }


    public function delete_faq(Request $request)
    {
        $post = Faq::findorfail($request->id);
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_faqs(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $post = Faq::findorfail($delete);
            $post->delete();
        }
        echo 'deleted';

    }


    public function delete_page(Request $request)
    {
        $post = Page::findorfail($request->id);

        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_pages(Request $request)
    {

        foreach ($request->selectedLanguage as $delete) {
            $post = Page::findorfail($delete);
            $post->delete();
        }
        echo 'deleted';

    }

    public function delete_attribute(Request $request)
    {
        $item = Attribute::findorfail($request->id);
        Attribute_category::where('attribute_id',$item->id)->delete();
        Attribute_value::where('attribute_id',$item->id)->delete();
        Attribute_product::where('attribute_id',$request->id)->delete();
        if ($item->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_attributes_val(Request $request)
    {
        Attribute_value::where('id',$request->id)->delete();

            echo 'deleted';

    }

    public function delete_attributes(Request $request)
    {

        foreach ($request->selectedLanguage as $delete) {
            $item = Attribute::findorfail($delete);
            Attribute_category::where('attribute_id',$item->id)->delete();
            Attribute_value::where('attribute_id',$item->id)->delete();
            Attribute_product::where('attribute_id',$item->id)->delete();
            $item->delete();
        }
        echo 'deleted';

    }

    public function delete_post_Category(Request $request)
    {
        $post = Postcategory::findorfail($request->id);
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_posts_Categories(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $post = Postcategory::findorfail($delete);
            $post->delete();
        }
        echo 'deleted';
    }

    public function delete_product_Category(Request $request)
    {
        $post = Category::findorfail($request->id);
        $post_parent = Category::where('parent',$request->id)->get();
        if (!count($post_parent)){
            if(file_exists(public_path() . '/' . $post->imgPath)){
                unlink(public_path() . '/' . $post->imgPath);
            }
            if ($post->delete()) {
                echo 'deleted';
            } else {
                echo 'Notdeleted';
            }
        }else{
            echo 'parent';
        }

    }

    public function delete_products_Categories(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
                $post = Category::findorfail($delete);
                if(file_exists(public_path() . '/' . $post->imgPath)){
                    unlink(public_path() . '/' . $post->imgPath);
                }
                if ($post->delete()) {
                    echo 'deleted';
                } else {
                    echo 'Notdeleted';
                }
        }

    }


    public function delete_Proposal_image(Request $request)
    {
        $post = Proposalimage::findorfail($request->id);
            if(file_exists(public_path() . '/' . $post->image)){
                unlink(public_path() . '/' . $post->image);
            }
            if ($post->delete()) {
                echo 'deleted';
            } else {
                echo 'Notdeleted';
            }


    }

    public function delete_Proposal_images(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
                $post = Proposalimage::findorfail($delete);
                if(file_exists(public_path() . '/' . $post->image)){
                    unlink(public_path() . '/' . $post->image);
                }
                if ($post->delete()) {
                    echo 'deleted';
                } else {
                    echo 'Notdeleted';
                }
        }

    }

    public function delete_user(Request $request)
    {
        $user = User::findorfail($request->id);
        if ($user->avatar){
            if (file_exists(public_path() . '/' . $user->avatar)) {
                unlink(public_path() . '/' . $user->avatar);
            }
    }
        if ($user->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_users(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $user = User::findorfail($delete);
            $user->delete();
        }
        echo 'deleted';
    }


    public function delete_club(Request $request)
    {
        $club = Club::findorfail($request->id);
        if ($club->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_clubs(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $club = Club::findorfail($delete);
            $club->delete();
        }
        echo 'deleted';
    }



    public function delete_complain(Request $request)
    {
        $club = Complain::findorfail($request->id);
        if ($club->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_complains(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $club = Complain::findorfail($delete);
            $club->delete();
        }
        echo 'deleted';
    }


    public function delete_contact(Request $request)
    {
        $club = Contact::findorfail($request->id);
        if ($club->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_contacts(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $club = Contact::findorfail($delete);
            $club->delete();
        }
        echo 'deleted';
    }



    public function RequestQuantity(Request $request)
    {
        $club = Request_quantity::findorfail($request->id);
        if ($club->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function RequestQuantities(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $club = Request_quantity::findorfail($delete);
            $club->delete();
        }
        echo 'deleted';
    }

    public function delete_discountcode(Request $request)
    {
        $club = Discountcode::findorfail($request->id);
        if ($club->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_discountcodes(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $club = Discountcode::findorfail($delete);
            $club->delete();
        }
        echo 'deleted';
    }

    public function delete_image_slider(Request $request)
    {
        $product = Slider::findorfail($request->id);
        if(file_exists(public_path() . '/' . $product->imgPath)){
            unlink(public_path() . '/' . $product->imgPath);
        }
        if ($product->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }
    public function set_link_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['link'=>$request->link]);
        echo 'ok';
    }
    public function set_Title_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['title'=>$request->link]);
        echo 'ok';
    }
    public function set_Text_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['text'=>$request->link]);
        echo 'ok';
    }
    public function set_position_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['position'=>$request->position]);
        echo 'ok';
    }
       public function set_alt_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['alt'=>$request->link]);
        echo 'ok';
    }

    public function set_status_slider(Request $request)
    {
        Slider::where('id',$request->id)->update(['status'=>$request->status]);
        echo 'ok';
    }

    public function set_send_status(Request $request)
    {
        Order::where('factor_number',$request->factor_number)->update(['send_status'=>$request->status]);
        if ($request->status!="در حال برسی" and $request->status!="در حال پیگیری سفارش") {
            $Order = Order::where('factor_number', $request->factor_number)->first();
            if ($Order->name == "") {
                $user_name = "کاربر گرامی، ";
            } else {
                $user_name = $Order->name . ' عزیز ';
            }

            $username = trim(setting()['username_sms']);
            $password = trim(setting()['password_sms']);
            $from = "+983000505";
            if ($request->status == "در حال بسته بندی") {
                $pattern_code = "cgb3r4ynym";
                $input_data = array("name" => $user_name);
            } elseif ($request->status == "ارسال شده") {
                $code = rand(10000, 99999);
                Order::where('factor_number', $request->factor_number)->update(['verification_code' => $code]);
                $pattern_code = "g3eyvt854i";
                $input_data = array("name" => $user_name, "verification-code" => $code);
            } elseif ($request->status == "تحویل داده شده") {
                $pattern_code = "519b91mjw1";
                $input_data = array("name" => $user_name);
            }
            $to = array($Order->mobile);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
        }
        echo 'ok';
    }
    public function set_day_status(Request $request)
    {
        Order::where('factor_number',$request->factor_number)->update(['day_status'=>$request->status]);
        echo 'ok';
    }
    public function delete_image_banner(Request $request)
    {
        $product = Banner::findorfail($request->id);
        if(file_exists(public_path() . '/' . $product->imgPath)){
            unlink(public_path() . '/' . $product->imgPath);
        }
        if ($product->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }
    public function set_link_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['link'=>$request->link]);
        echo 'ok';
    }
    public function set_Title_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['title'=>$request->link]);
        echo 'ok';
    }
    public function set_Text_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['text'=>$request->link]);
        echo 'ok';
    }
    public function set_alt_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['alt'=>$request->link]);
        echo 'ok';
    }
    public function set_status_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['status'=>$request->status]);
        echo 'ok';
    }
    public function set_position_banner(Request $request)
    {
        Banner::where('id',$request->id)->update(['position'=>$request->position]);
        echo 'ok';
    }
    public function delete_image_brand(Request $request)
    {
        $product = Brand::findorfail($request->id);
        if(file_exists(public_path() . '/' . $product->imgPath)){
            unlink(public_path() . '/' . $product->imgPath);
        }
        if ($product->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }
    public function set_link_brand(Request $request)
    {
        Brand::where('id',$request->id)->update(['link'=>$request->link]);
        echo 'ok';
    }
    public function set_title_brand(Request $request)
    {
        Brand::where('id',$request->id)->update(['title'=>$request->link,'link'=>$request->link]);
        echo 'ok';
    }
    public function set_alt_brand(Request $request)
    {
        Brand::where('id',$request->id)->update(['alt'=>$request->link]);
        echo 'ok';
    }
    public function set_status_brand(Request $request)
    {
        Brand::where('id',$request->id)->update(['status'=>$request->status]);
        echo 'ok';
    }

   public function delete_product(Request $request)
    {
        $product = Product::findorfail($request->id);

        $galleries=Gallery::where('product_id',$product->id)->get();
        if (count($galleries)){
            foreach ($galleries as $gallery){
                if(file_exists(public_path() . '/' . $gallery->path)){
                    unlink(public_path() . '/' . $gallery->path);
                }
            }
        }
        if(file_exists(public_path() . '/' . $product->image)){
            unlink(public_path() . '/' . $product->image);
        }

        if ($product->delete()) {
            Feature::where('product_id',$request->id)->delete();
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_products(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $product = Product::findorfail($delete);
            if(file_exists(public_path() . '/' . $product->image)){
                unlink(public_path() . '/' . $product->image);
            }
            $galleries=Gallery::where('product_id',$product->id)->get();
            if (count($galleries)){
                foreach ($galleries as $gallery){
                    if(file_exists(public_path() . '/' . $gallery->path)){
                        unlink(public_path() . '/' . $gallery->path);
                    }
                }
            }
            $product->delete();
            Feature::where('product_id',$request->id)->delete();
        }
        echo 'deleted';
    }

    public function delete_role(Request $request)
    {
        $role = Role::findorfail($request->id);
        if ($role->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_roles(Request $request)
    {
        foreach ($request->selectedLanguage as $delete) {
            $role = Role::findorfail($delete);
            $role->delete();
        }
        echo 'deleted';
    }
    public function service_comment_ajax(Request $request)
    {
        Post_comments::where('id',$request->id)->update(['status'=>$request->status]);
    }
    public function service_comment_ajax_delete(Request $request)
    {
        Post_comments::where('id',$request->id)->delete();
    }

    public function product_comment_ajax(Request $request)
    {
        Comment::where('id',$request->id)->update(['status'=>$request->status]);
    }

    public function product_comment_ajax_delete(Request $request)
    {
        $comment=Comment::findorfail($request->id);
        Comment::where('parent',$comment->id)->delete();
        $comment->delete();
    }

    public function getoffcode(Request $request)
    {
        $user = User::findorfail($request->userid);
        if ($user->code_expiration != date('Y-m-d')) {
            $offcode = Offcode::inRandomOrder()->where('product_id', $request->id)->first();
            if ($offcode) {
                $offcode->delete();
                $user->code_expiration = date('Y-m-d');
                $user->save();
            }
            return response()->json([
                'msg' => $offcode->code
            ]);
        }else{
            return response()->json([
                'msg' => 'کاربر گرامی در روز فقط یک بار مجاز به دریافت کد تخفیف می باشید!'
            ]);
        }
    }

    public function setlike(Request $request)
    {
        Cookie::queue($request->id, $request->id, 2628000);
        $productId = Cookie::get($request->id);

        if($productId != $request->id){
            $miniproduct = Miniproduct::findorfail($request->id);
            $miniproduct->islike = $miniproduct->islike + 1;
            $miniproduct->save();
            return response()->json([
                'msg' => $miniproduct->islike
            ]);
        }

    }

    public function setdislike(Request $request)
    {
        Cookie::queue($request->id, $request->id, 2628000);
        $productId = Cookie::get($request->id);

        if($productId != $request->id){
        $miniproduct = Miniproduct::findorfail($request->id);
        $miniproduct->dislike = $miniproduct->dislike + 1;
        $miniproduct->save();
        return response()->json([
            'msg' => $miniproduct->dislike
        ]);
        }
    }

    public function change_price_monys_user(Request $request)
    {
        Walletsreport::where(['askformoney'=>'YES','id'=>$request->row_id])->update(['price'=>$request->price]);
        return response()->json([
            'price' => number_format($request->price)
        ]);
    }

    public function commentminiproduct(Request $request)
    {

        $Commentminiproduct = new Commentminiproducts();
        $Commentminiproduct->rate = $request->rate;
        $Commentminiproduct->content = $request->txt;
        $Commentminiproduct->product_id = $request->id;
        $Commentminiproduct->user_id = $request->userid;
        $Commentminiproduct->save();
        return response()->json([
            'msg' => 'ok'
        ]);
    }
    public function delete_special(Request $request)
    {
        $special = Product::where('id', $request->id)->first();
        $special->special = "NO";
        $special->save();
        echo "delete";
    }

    public function complain_details(Request $request)
    {
        $complain=Complain::where('id',$request->id)->with('user')->first();
        if ($complain->user->name==""){$name=$complain->user->mobile;}else{$name=$complain->user->name.' '.$complain->user->family;}
        return response([
            'name'=>$name,
            'CaseTypeCode'=>$complain->CaseTypeCode,
            'title'=>$complain->title,
            'Message'=>$complain->Message,
            'status'=>$complain->status,
            'answer'=>$complain->answer,
            'id'=>$complain->id,
            'user_id'=>$complain->user->id,
            'created_at'=>Verta::instance($complain->created_at)->format('%d %B %Y'),

        ]);
    }

    public function complain_save_details(Request $request)
    {
        $id=$request->data_val[2]['value'];
        $status=$request->data_val[1]['value'];
        $answer=$request->data_val[4]['value'];

        $Complain=Complain::where('id',$id)->first();
        $Complain->status=$status;
        $Complain->answer=$answer;
        $Complain->save();

        if ($answer!="" and $status=="SEEN"){
            $user=User::find($request->data_val[3]['value']);
            if ($user->name=="" and $user->family==""){
                $user_name="کاربر گرامی، ";
            }else{
                $user_name=$user->name.' '.$user->family.' عزیز ';
            }

            $username = trim(setting()['username_sms']);
            $password = trim(setting()['password_sms']);
            $from = "+983000505";
            $pattern_code = "cdwofev8vu";
            $to = array($user->mobile);
            $input_data = array("name" => $user_name);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
        }

    }

    public function comment_product_details(Request $request)
    {
        $Comment=Comment::where('id',$request->id)->with('user')->first();
        if ($Comment->user->name==""){$name=$Comment->user->mobile;}else{$name=$Comment->user->name.' '.$Comment->user->family;}
        return response([
            'name'=>$name,
            'product_title'=>$Comment->product->title,
            'product_slug'=>$Comment->product->slug,
            'title'=>$Comment->title,
            'Message'=>$Comment->content,
            'status'=>$Comment->status,
            'answer'=>$Comment->answer,
            'id'=>$Comment->id,
            'created_at'=>Verta::instance($Comment->created_at)->format('%d %B %Y'),

        ]);
    }

    public function product_save_details(Request $request)
    {
        $id=$request->data_val[2]['value'];
        $status=$request->data_val[1]['value'];
        $Comment=Comment::where('id',$id)->first();
        $Comment->status=$status;
        $Comment->save();
        return response([
            'id'=>$id,
            'status'=>$status,
        ]);
    }


    public function comment_post_details(Request $request)
    {
        $Comment=Post_comments::where('id',$request->id)->with('post')->first();
        return response([
            'name'=>$Comment->name,
            'product_title'=>$Comment->post->title,
            'product_slug'=>$Comment->post->slug,
            'title'=>$Comment->title,
            'Message'=>$Comment->content,
            'status'=>$Comment->status,
            'answer'=>$Comment->answer,
            'id'=>$Comment->id,
            'created_at'=>Verta::instance($Comment->created_at)->format('%d %B %Y'),

        ]);
    }

    public function post_save_details(Request $request)
    {
        $id=$request->data_val[2]['value'];
        $status=$request->data_val[1]['value'];
        $Comment=Post_comments::where('id',$id)->first();
        $Comment->status=$status;
        $Comment->save();
        return response([
            'id'=>$id,
            'status'=>$status,
        ]);
    }
    public function delete_comment_post(Request $request)
    {
        $post = Post_comments::findorfail($request->id);
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_comments_post(Request $request)
    {

        foreach ($request->selectedLanguage as $delete) {
            $post = Post_comments::findorfail($delete);
            $post->delete();
        }
        echo 'deleted';

    }

    public function delete_comment_product(Request $request)
    {
        $post = Comment::findorfail($request->id);
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function delete_comments_product(Request $request)
    {

        foreach ($request->selectedLanguage as $delete) {
            $post = Comment::findorfail($delete);
            $post->delete();
        }
        echo 'deleted';

    }

    public function send_users_sms(Request $request)
    {
        $username = trim(setting()['username_sms']);
        $password = trim(setting()['password_sms']);
        $from = "+983000505";
        $pattern_code = "sv2wvowq70";
        $users=User::where('role','0')->get();
        foreach ($users as $user){

            $to = array($user->mobile);
            $input_data = array("name" => $request->sms);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            sleep(30);
        }

        if ($response){
            return response([
                'msg'=>'true'
            ]);
        }else{
            return response([
                'msg'=>'false'
            ]);
        }
    }
    public function delete_message(Request $request)
    {
        $post = Message::findorfail($request->id);
        if ($post->delete()) {
            echo 'deleted';
        } else {
            echo 'Notdeleted';
        }
    }

    public function change_status_message(Request $request)
    {
        Message::where('id',$request->id)->update(['status'=>$request->status]);
        echo 'ok';
    }

}
