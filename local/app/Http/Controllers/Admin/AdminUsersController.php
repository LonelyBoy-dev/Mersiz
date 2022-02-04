<?php

namespace App\Http\Controllers\Admin;

use App\Allreport;
use App\Exports\OrderReportExcel;
use App\Exports\UserReportExcel;
use App\Package;
use App\Tree;
use App\User;
use App\Wallet;
use App\Walletsreport;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        abort_unless(Gate::allows('users_index'), 403, 'شما به این بخش دسترسی ندارید');
        $users = User::where('id','!=','1')->orderBy('id', 'desc')->get();
        $Active="users";
        return view('adminbizness.users.index', compact(['users','Active']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('users_create'), 403, 'شما به این بخش دسترسی ندارید');
        return view('adminbizness.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'family' => 'required|string|max:255|min:3',
            'national_code' => 'nullable|max:10|min:10|unique:users,national_code',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'address' => 'nullable|min:10',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'نام را وارد کنید',
            'name.min' => 'حداقل 3 کاراکتر می باشد',
            'family.required' => 'نام خانوادگی را وارد کنید',
            'family.min' => 'حداقل 3 کاراکتر می باشد',
            'national_code.unique' => 'کدملی از قبل موجود می باشد',
            'national_code.min' => 'کدملی نامعتبر است',
            'national_code.max' => 'کدملی نامعتبر است',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.digits' => 'شماره موبایل صحیح نیست',
            'mobile.unique' => 'شماره موبایل را وارد کنید',
            'mobile.regex' => 'شماره موبایل صحیح نیست',
            'email.required' => 'ایمیل  را وارد کنید',
            'email.email' => 'ایمیل صحیح نمی باشد',
            'address.min' => 'آدرس کوتاه می باشد',
            'password.required' => 'رمز عبور را وارد کنید',
            'password.min' => 'رمز عبور حداقل 6 کاراکتر می باشد',
            'password.confirmed' => 'رمز عبور و تکرار رمز عبور یکسان نیست',
            'password.regex' => 'رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
        ]);
        $user=new User();
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
        $user->password = bcrypt($request->input('password'));

        if ($request->active_user=="on"){
            $user->status = "ACTIVE";
        }
        $user->save();
        session()->put('user-create', 'کاربر جدید با موفقیت اضافه شد');
        return redirect(route('user-s.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $users = $this->get_user($user->reference_code);


        //return view('adminbizness.users.show',compact(['users']));
    }

    public function get_user($reference_code)
    {
        $users = Tree::where('reference', $reference_code)->get();
        foreach ($users as $user) {
            $this->get_user($user->reference_code);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Gate::allows('users_edit'), 403, 'شما به این بخش دسترسی ندارید');
        $user = User::where('id', $id)->first();
        $users = User::all();
        return view('adminbizness.users.edit', compact(['user', 'users']));
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
        $user = User::findorfail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'family' => 'required|string|max:255|min:3',
            'national_code' => 'nullable|max:10|min:10|unique:users,national_code,' . $id,
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|unique:users,mobile,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'nullable|min:10',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'نام را وارد کنید',
            'family.required' => 'نام خانوادگی را وارد کنید',
            'national_code.unique' => 'کدملی از قبل موجود می باشد',
            'national_code.min' => 'کدملی نامعتبر است',
            'national_code.max' => 'کدملی نامعتبر است',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.digits' => 'شماره موبایل صحیح نیست',
            'mobile.unique' => 'شماره موبایل از قیل وجود دارد',
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
        if ($request->Marketing_price==""){
            $user->Marketing_price = "0";
        }else{
            $user->Marketing_price = $request->Marketing_price;
        }

        if ($request->password!=""){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        session()->put('user_chagne', 'تغییرات با موفقیت ذخیره شده');

        return redirect(route('user-s.edit', $id));

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



    public function report()
    {
        return Excel::download(new UserReportExcel(), 'UsersReport.xlsx');
    }
}
