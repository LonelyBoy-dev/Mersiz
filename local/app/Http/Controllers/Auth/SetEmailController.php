<?php

namespace App\Http\Controllers\Auth;

use App\Mobile_verified;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SetEmailController extends Controller
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
            'password' => 'required|string|min:6',
        ],[
            'email.required'=>'ایمیل یا شماره موبایل را وارد کنید',
            'email.email'=>'ایمیل نامعتبر است',
            'password.min'=>'رمز عبور حداقل 6 کاراکتر می باشد',
            'email.unique'=>'ایمیل مطلعق به شخص دیگری می باشد',
            'password.required'=>'رمز عبور را وارد کنید'

        ]);

        $user=new User();
        $user->mobile=session('register-new-user-setEmail');
        $user->password=bcrypt($request->password);
        $user->save();

        $us=User::find($user->id);
        $v = new Verta();
        $us->Marketing_link=$v->year . $v->month . $v->day.$user->id;
        $us->save();
        session()->put('registered','registered');

        Auth::loginUsingId($user->id);
        Mobile_verified::where('mobile',session('register-new-user-setEmail'))->delete();
        session()->forget('register-new-user-setEmail');
        session()->forget('user-verify-phone-number');
        return redirect('/welcome');

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
