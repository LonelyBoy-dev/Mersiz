<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Http\Requests\RegisterRequest;
use App\Tree;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jsonString = file_get_contents('js/iranstates.json');
        $state = json_decode($jsonString, true);


        foreach ($state as $key => $value) {
            $states[$key] = $key;
        }
        return view('auth.register', compact(['states']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function verifire_password(Request $request)
    {
        $national_code = User::where('national_code', $request->input('national_code'))->first();

        $this->validate($request, [
            'national_code' => 'required|min:10|max:10',
        ], [
            'national_code.required' => 'کد ملی را وارد کنید',
            'national_code.min' => 'کد ملی نامعتبر است',
            'national_code.max' => 'کد ملی نامعتبر است',
        ]);

        if (!empty($national_code)) {
            $length = 6; // تعداد حروف و اعداد که برای کاربر نمایش داده میشوند
            $str = "123456789";
            $max = strlen($str) - 1;
            $random = "";
            for ($i = 0; $i < $length; $i++) {
                $number = mt_rand(0, $max);
                $random .= substr($str, $number, 1);
            }
            $national_code->verifire_code = $random;
            $national_code->save();

            $username = "udreams";
            $password = 'fardabia20002000';
            $from = "+983000505";
            $pattern_code = "30a206hbb9";
            $to = array($national_code->mobile);
            $input_data = array("verification-code" => $random);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            session()->put('verifire_code_password', $national_code->mobile);

            return redirect('password/verify');

        } else {
            session()->put('verifire_password', 'کد ملی  پیدا نشد !');

            return redirect('password/reset');
        }


    }

    public function verifire_code_password()
    {


        if (!empty(session('verifire_code_password'))) {
            return view('auth.passwords.verify_password');
        } else {

            return redirect('password/reset');

        }
    }

    public function verifire_code_password_code(Request $request)
    {

        if (!empty($request->input('mobile'))) {

            $mobile = User::where('mobile', $request->input('mobile'))->first();

            if ($mobile->verifire_code == $request->input('code')) {
                session()->put('verifire_code_password', $request->input('mobile'));
                return view('auth.passwords.pass');
            } else {
                session()->put('کد تایید اشتباه است', 'کد تایید اشتباه است');
                return redirect('password/verify');
            }
        } else {
            return redirect('password/reset');
        }
    }

    public function reset_password(Request $request)
    {

        session()->put('verifire_code_password', $request->input('mobile'));


        $mobile = User::where('mobile', $request->input('mobile'))->first();

        if ($request->input('mobile') == "") {
            session()->put('reset_password_error', 'ویرایش پسورد با مشکل مواجه شد لفطا دوباره تلاش کنید !');
            return redirect('password/reset');
        } else {

            $mobile->password = bcrypt($request->input('password'));
            $mobile->save();

            $username = "udreams";
            $password = 'fardabia20002000';
            $from = "+983000505";
            $pattern_code = "74voq7ea7d";
            $to = array($mobile->mobile);
            $input_data = array("name" => $mobile->username);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);

            session()->put('reset_password', 'success');
            return redirect('login');

        }

    }

    public function verifire()
    {


        if (!empty(session('verifire_mobile'))) {
            return view('auth.verifire');
        } else {

            return redirect('register');

        }

    }

    public function verifire_code(Request $request)
    {

        $code_user = User::where('mobile', $request->input('mobile'))->first();

        if ($code_user->verifire_code == $request->input('code')) {
            $code_user->verifire = 'YES';
            $code_user->save();

            return redirect('login');

        } else {
            session()->put('verifire_notok', 'کد تائید اشتباه است');
            return redirect('verifire');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $mobile = User::where('mobile', $request->input('mobile'))->first();
        session()->put('user_info_register', $request->input());

        if (!empty($mobile)) {

            if ($mobile->verifire == 'NO') {

                $length = 6; // تعداد حروف و اعداد که برای کاربر نمایش داده میشوند
                $str = "123456789";
                $max = strlen($str) - 1;
                $random = "";
                for ($i = 0; $i < $length; $i++) {
                    $number = mt_rand(0, $max);
                    $random .= substr($str, $number, 1);
                }
                /*session()->put('code-taid',$random);*/
                $mobile->verifire_code = $random;
                $mobile->save();

                $username = "udreams";
                $password = 'fardabia20002000';
                $from = "+983000505";
                $pattern_code = "30a206hbb9";
                $to = array($request->input('mobile'));
                $input_data = array("verification-code" => $random);
                $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($handler);

                session()->put('verifire_mobile', $request->input('mobile'));


                return redirect('verifire');

            } else {
                $this->validate($request, [
                    'name' => 'required|string|max:255|min:3|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
                    'reference' => 'required|max:255|min:3',
                    'pin_code' => 'required|max:255|min:3',
                    'national_code' => 'required|max:10|min:10|unique:users',
                    'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users',
                    'username' => 'required|string|min:3|max:255|unique:users|regex:/^[A-Za-z][A-Za-z0-9]*$/',
                    'password' => 'required|min:6|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9])(?=.*[\d\x]).*$/',
                    'question' => 'required',
                    'answer' => 'required|string|max:255|min:3',
                ], [
                    'name.required' => 'نام و نام خانوادگی را وارد کنید',
                    'name.regex' => 'نام و نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
                    'name.min' => 'حدقل 3 کاراکتر',
                    'username.min' => 'حدقل 3 کاراکتر',
                    'username.regex' => 'از کلمات لاتین استفاده کنید',
                    'reference.required' => 'کد حامی را وارد کنید',
                    'pin_code.required' => 'کد آپ لاین را وارد کنید',
                    'national_code.required' => 'کد ملی را وارد کنید',
                    'national_code.unique' => 'کد ملی متعلق به شخص دیگری است',
                    'mobile.unique' => 'شماره موبایل از قبل موجود است',
                    'national_code.min' => 'کد ملی نامعتبر است',
                    'national_code.max' => 'کد ملی نامعتبر است',
                    'mobile.required' => 'شماره موبایل را وارد کنید',
                    'mobile.regex' => 'شماره موبایل نامعتبر است',
                    'email.required' => 'ایمیل را وارد کنید',
                    'email.email' => 'ایمیل نامعتبر است',
                    'question.required' => 'یک سوال امنیتی انتخاب کنید',
                    'answer.required' => 'جواب سوال خود را وارد کنید',
                    'answer.min' => 'حدقل 3 کاراکتر',
                    'required.password' => 'پسورد را وارد کنید',
                    'password.min' => 'حداقل پسورد 6 کاراکتر است',
                    'password.confirmed' => 'لطفا رمز عبور یکسان وارد کنید',
                    'password.regex' => ' رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
                ]);
            }
        } else {
            if ($request->input('atba')=="1"){
                $this->validate($request, [
                    'name' => 'required|string|max:255|min:3|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
                    'reference' => 'required|max:255|min:3',
                    'pin_code' => 'required|max:255|min:3',
                    'atba_code' => 'required|max:9|min:8|unique:users',
                    'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users',
                    'username' => 'required|string|min:3|max:255|unique:users|regex:/^[A-Za-z][A-Za-z0-9]*$/',
                    'password' => 'required|min:6|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9])(?=.*[\d\x]).*$/',
                    'question' => 'required',
                    'answer' => 'required|string|max:255|min:3',
                ], [
                    'name.required' => 'نام و نام خانوادگی را وارد کنید',
                    'name.regex' => 'نام و نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
                    'name.min' => 'حدقل 3 کاراکتر',
                    'username.min' => 'حدقل 3 کاراکتر',
                    'username.regex' => 'از کلمات لاتین استفاده کنید',
                    'reference.required' => 'کد حامی را وارد کنید',
                    'pin_code.required' => 'کد معرف خود را وارد کنید',
                    'atba_code.required' => 'کد اتباع را وارد کنید',
                    'atba_code.unique' => 'کد اتباع متعلق به شخص دیگری است',
                    'mobile.unique' => 'شماره موبایل از قبل موجود است',
                    'atba_code.min' => 'کد اتباع نامعتبر است',
                    'atba_code.max' => 'کد اتباع نامعتبر است',
                    'mobile.required' => 'شماره موبایل را وارد کنید',
                    'mobile.regex' => 'شماره موبایل نامعتبر است',
                    'mobile.digits' => 'شماره موبایل نامعتبر است',
                    'email.required' => 'ایمیل را وارد کنید',
                    'email.email' => 'ایمیل نامعتبر است',
                    'question.required' => 'یک سوال امنیتی انتخاب کنید',
                    'answer.required' => 'جواب سوال خود را وارد کنید',
                    'answer.min' => 'حدقل 3 کاراکتر',
                    'required.password' => 'پسورد را وارد کنید',
                    'password.min' => 'حداقل پسورد 6 کاراکتر است',
                    'password.confirmed' => 'لطفا رمز عبور یکسان وارد کنید',
                    'password.regex' => ' رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
                ]);
            }else {
                $this->validate($request, [
                    'name' => 'required|string|max:255|min:3|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
                    'family' => 'required|string|max:255|min:3|regex:/^[ آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئ\s]+$/',
                    'reference' => 'required|max:255|min:3',
                    'pin_code' => 'required|max:255|min:3',
                    'national_code' => 'required|max:10|min:10|unique:users',
                    'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users',
                    'username' => 'required|string|min:3|max:255|unique:users|regex:/^[A-Za-z][A-Za-z0-9]*$/',
                    'password' => 'required|min:6|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z,A-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
                    'question' => 'required',
                    'answer' => 'required|string|max:255|min:3',
                ], [
                    'name.required' => 'نام و نام خانوادگی را وارد کنید',
                    'name.regex' => ' نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
                    'name.min' => 'حدقل 3 کاراکتر',
                    'family.required' => 'نام خانوادگی را وارد کنید',
                    'family.regex' => 'نام خانوادگی نمی تواند عدد یا حروف لاتین باشد.',
                    'family.min' => 'حدقل 3 کاراکتر',
                    'username.min' => 'حدقل 3 کاراکتر',
                    'username.regex' => 'از کلمات لاتین استفاده کنید',
                    'reference.required' => 'کد حامی را وارد کنید',
                    'pin_code.required' => 'کد معرف خود را وارد کنید',
                    'national_code.required' => 'کد ملی را وارد کنید',
                    'national_code.unique' => 'کد ملی متعلق به شخص دیگری است',
                    'mobile.unique' => 'شماره موبایل از قبل موجود است',
                    'national_code.min' => 'کد ملی نامعتبر است',
                    'national_code.max' => 'کد ملی نامعتبر است',
                    'mobile.required' => 'شماره موبایل را وارد کنید',
                    'mobile.regex' => 'شماره موبایل نامعتبر است',
                    'mobile.digits' => 'شماره موبایل نامعتبر است',
                    'email.required' => 'ایمیل را وارد کنید',
                    'email.email' => 'ایمیل نامعتبر است',
                    'question.required' => 'یک سوال امنیتی انتخاب کنید',
                    'answer.required' => 'جواب سوال خود را وارد کنید',
                    'answer.min' => 'حدقل 3 کاراکتر',
                    'required.password' => 'پسورد را وارد کنید',
                    'password.min' => 'حداقل پسورد 6 کاراکتر است',
                    'password.confirmed' => 'لطفا رمز عبور یکسان وارد کنید',
                    'password.regex' => ' رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
                ]);
            }
            $v = Verta();
            $user = new User();
            $users = Tree::where('reference_code', $request->input('reference'))->first();
            $user->name = $request->input('name');
            $user->family = $request->input('family');
            $user->username = $request->input('username');


            if ($users) {

                $pin_code = Tree::where('reference_code', $request->input('pin_code'))->first();

                if ($pin_code) {

                    $reference = strtoupper($request->input('reference'));
                    $reference = trim($reference);
                    $user->reference=$reference;
                    $refuser = Tree::where('reference_code', $reference)->first();
                    if ($refuser->right_hand == "") {
                        $refuser_check = User::where('reference', $request->input('reference'))->get();
                        if (count($refuser_check)<2){

                        $pin_code=strtoupper($request->input('pin_code'));
                        $pin_code = trim($pin_code);
                        $user->pin_code =$pin_code;
                        $user->national_code = $request->input('national_code');
                        $user->mobile = $request->input('mobile');
                        $user->sex = $request->input('sex');
                        $user->ostan = $request->input('ostan');
                        $user->city = $request->input('city');
                        $user->ostan_id = $request->input('ostan_id');
                        $user->city_id = $request->input('city_id');
                        $user->answer = $request->input('answer');
                        $user->question_id = $request->input('question');

                        if ($request->input('atba')=="1"){
                            $user->atba="غیر ایرانی";
                            $user->atba_code=$request->input('atba_code');
                        }else{
                            $user->atba="ایرانی";
                        }


                        $user->password = bcrypt($request->input('password'));
                        $user->role = 0;
                        $user->surface = 1;
                        $user->level = 1;
                        $user->avatar='';

                        $length = 6; // تعداد حروف و اعداد که برای کاربر نمایش داده میشوند
                        $str = "123456789";
                        $max = strlen($str) - 1;
                        $random = "";
                        for ($i = 0; $i < $length; $i++) {
                            $number = mt_rand(0, $max);
                            $random .= substr($str, $number, 1);
                        }
                        /*session()->put('code-taid',$random);*/
                        $user->verifire_code = $random;


                        $username = "udreams";
                        $password = 'fardabia20002000';
                        $from = "+983000505";
                        $pattern_code = "30a206hbb9";
                        $to = array($request->input('mobile'));
                        $input_data = array("verification-code" => $random);
                        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
                        $handler = curl_init($url);
                        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($handler);



                        $user->save();

                        if ($file = $request->file('avatar')) {
                            $name = time() . $file->getClientOriginalName();
                            $file->move('images/user_profile/'.$user->id.'/', $name);
                            $user->avatar = 'images/user_profile/'.$user->id.'/'.$name;
                            $user->save();
                        }


                        /*$user_code = User::findorfail($user->id);
                        $code = 'UD-' . $v->year . '' . $v->month . '' . $v->day . '' . $user->id;
                        $user_code->reference_code = $code;
                        $user_code->save();*/

                        $wallet=new Wallet();
                        $wallet->user_id=$user->id;
                        $wallet->token=md5(uniqid(rand(), true)).$user->id;
                        $wallet->price=0;
                        $wallet->save();

                        session()->put('verifire_mobile', $request->input('mobile'));
                        return redirect('verifire');
                    } else {
                        session()->put('user_info_register', $request->input());
                        session()->put('not-refrence-code', 'کاربر گرامی حامی شما محدودیت تعداد نفرات مستقیم دارد!');
                        return redirect('register');
                    }
                    } else {
                        session()->put('user_info_register', $request->input());
                        session()->put('not-refrence-code', 'کاربر گرامی حامی شما محدودیت تعداد نفرات مستقیم دارد!');
                        return redirect('register');
                    }
                } else {
                    session()->put('user_info_register', $request->input());
                    session()->put('not-refrence-code', 'کاربر گرامی کد معرف شما وجود ندارد!');
                    return redirect('register');
                }
            } else {
                session()->put('user_info_register', $request->input());
                session()->put('not-refrence-code', 'کاربر گرامی کد حامی شما معتبر نیست!');
                return redirect('register');
            }


        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //
    }
}
