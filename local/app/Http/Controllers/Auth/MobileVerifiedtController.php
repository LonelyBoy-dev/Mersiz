<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mobile_verified;
use App\User;

class MobileVerifiedtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|digits:11|unique:users|regex:/(09)[0-9]{9}/',
            'rules'=>'required',
        ],[
            'mobile.required'=>"شماره موبایل خود را وارد کنید",
            'mobile.numeric'=>"شماره موبایل باید عدد باشد",
            'mobile.regex'=>"شماره موبایل صحیح نمی باشد",
            'mobile.unique'=>"شماره موبایل از قبل موجود می باشد.",
        ]);

        Mobile_verified::where('mobile',$request->mobile)->delete();
        $mobile_verified=new Mobile_verified();
        $mobile_verified->mobile=$request->mobile;
        $mobile_verified->mobile_verified_at = rand(10000, 99999);
        $mobile_verified->save();

        $username = trim(setting()['username_sms']);
        $password = trim(setting()['password_sms']);
        $from = "+983000505";
        $pattern_code = "u5550aipad";
        $to = array($mobile_verified->mobile);
        $input_data = array("verification-code" => $mobile_verified->mobile_verified_at);
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        if ($response){
            session()->put('user-verify-phone-number', $request->mobile);
            return redirect('/verify-phone-number');
        }else{
            session()->put('sms-error', 'مشکل در ارسال پیامک');
            return redirect('/register');
        }

    }

    public function verify_phone_number(Request $request)
    {
        $verify_code_number=$request->OtpCode1.$request->OtpCode2.$request->OtpCode3.$request->OtpCode4.$request->OtpCode5;
        $mobile_verified=Mobile_verified::where('mobile',$request->mobile)->first();
        if ($mobile_verified and $mobile_verified->mobile_verified_at==$verify_code_number) {
            session()->put('register-new-user-setEmail',$mobile_verified->mobile);
            return redirect('/register-new-user');
        }else{
            session()->put('verify-phone-number_alert','کد وارد شده صحیح نمی باشد!');
            return redirect('/verify-phone-number');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
