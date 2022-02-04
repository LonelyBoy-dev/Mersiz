<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findorfail(Auth::id());
        return view('adminbizness.profiles.index', compact(['user']));
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
        //
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
        $user=User::findorfail(Auth::id());

        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'family' => 'required|string|max:255|min:3',
            'national_code' => 'nullable|max:10|min:10|unique:users,national_code,' . $id,
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users,mobile,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'nullable|min:10',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'نام را وارد کنید',
            'family.required' => 'نام خانوادگی را وارد کنید',
            'national_code.unique' => 'کدملی از قبل موجود می باشد',
            'national_code.min' => 'کدملی نامعتبر است',
            'national_code.max' => 'کدملی نامعتبر است',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.unique' => 'شماره موبایل را وارد کنید',
            'mobile.regex' => 'شماره موبایل صحیح نیست',
            'email.required' => 'ایمیل  را وارد کنید',
            'email.email' => 'ایمیل صحیح نمی باشد',
            'address.min' => 'آدرس کوتاه می باشد',
            'password.min' => 'رمز عبور حداقل 8 کاراکتر می باشد',
            'password.confirmed' => 'رمز عبور و تکرار رمز عبور یکسان نیست',
            'password.regex' => 'رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
        ]);
        $user->name = $request->name;
        $user->family = $request->family;
        $user->mobile = $request->mobile;
        $user->sex = $request->sex;
        $user->ostan_id = $request->ostan_id;
        $user->ostan = $request->ostan;
        $user->city_id = $request->city_id;
        $user->city = $request->city;
        $user->email = $request->email;
        $user->address = $request->address;
        if ($request->password!=""){
            $user->password = bcrypt($request->input('password'));
        }
        //$user->profile_status="Waiting";
        $user->save();
        session()->put('user_change', 'تغییرات با موفقیت ذخیره شده');

        return redirect(route('profile.index'));
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
