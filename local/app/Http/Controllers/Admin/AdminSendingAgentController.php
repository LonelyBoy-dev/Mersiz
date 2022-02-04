<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Registersendingcode;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminSendingAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('Sending_agent'),403,'شما به این بخش دسترسی ندارید');
        $registersendingcodes=Registersendingcode::where('user_id',Auth::id())->get();
        $Active="Sending_agent";
        return view('adminbizness.Sending-agent.index', compact('registersendingcodes','Active'));
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
            'factor_number' => 'required',
            'verification_code' => 'required',
        ], [
            'factor_number.required'=>'شماره فاکتور الزامی است',
            'verification_code.required'=>'کد سفارش الزامی است',
        ]);

        $registersendingcode=Order::where('factor_number',trim($request->factor_number))->first();
        if ($registersendingcode!=""){
            if ($registersendingcode->verification_code==trim($request->verification_code)){
                $exist_sendingcode=Registersendingcode::where('factor_number',$request->factor_number)->first();
                if ($exist_sendingcode==""){
                    $sendingcode=new Registersendingcode();
                    $sendingcode->factor_number=$request->factor_number;
                    $sendingcode->verification_code=$request->verification_code;
                    $sendingcode->user_id=Auth::id();
                    $sendingcode->save();
                    Order::where('factor_number',$request->factor_number)->update(['send_status'=>'تحویل داده شده']);


                    if ($registersendingcode->name==""){
                        $user_name="کاربر گرامی، ";
                    }else{
                        $user_name=$registersendingcode->name.' عزیز ';
                    }
                    $username = trim(setting()['username_sms']);
                    $password = trim(setting()['password_sms']);
                    $from = "+983000505";
                    $pattern_code = "519b91mjw1";
                    $input_data = array("name" => $user_name);
                    $to = array($registersendingcode->mobile);
                    $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
                    $handler = curl_init($url);
                    curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
                    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($handler);


                    session()->put('registersendingcode_save','با موفقیت ثبت شد');
                }else{
                    session()->put('registersendingcode','کد ارسال و شماره فاکتور از قبل ثبت شده است');
                }

            }else{
                session()->put('registersendingcode','کد سفاره اشتباه می باشد');
            }
        }else{
            session()->put('registersendingcode','شماره فاکتور وارد شده صحیح نیست');

        }
        return redirect('/admin/Sending-agent');
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
