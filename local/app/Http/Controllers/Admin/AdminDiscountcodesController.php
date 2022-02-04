<?php

namespace App\Http\Controllers\Admin;

use App\Discountcode;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDiscountcodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('discountcodes'),403,'شما به این بخش دسترسی ندارید');
        $discountcodes=Discountcode::all();
        $Active_list="tool";
        $Active="discountcodes";
        return view('adminbizness.discountcodes.index',compact(['discountcodes','Active_list','Active']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Active_list="tool";
        $Active="discountcodes";
        return view('adminbizness.discountcodes.create',compact('Active_list','Active'));
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
            'code' => 'required|unique:discountcodes',
            'darsad' => 'required',
            'max' => 'required',
            'end_date' => 'required',
        ], [
            'code.required'=>'فیلد کد نمی تواند خالی باشد',
            'code.unique'=>'فیلد کد نمی تواند تکراری باشد',
            'darsad.required'=>'فیلد درصد تخفیف نمی تواند خالی باشد',
            'max.required'=>'فیلد تعداد قابل استفاده نمی تواند خالی باشد',
        ]);
        $code=new Discountcode();
        $code->code=$request->code;
        $code->darsad=$request->darsad;
        $code->max=$request->max;
        $code->end_date=$request->end_date;
        $code->save();
        session()->put('code-create','کد تخفیف جدید با موفقیت ایجاد شد');
        return redirect('/admin/discountcodes');
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
        abort_unless(Gate::allows('discountcodes'),403,'شما به این بخش دسترسی ندارید');
        $discountcode=Discountcode::findorfail($id);

        $Active_list="tool";
        $Active="discountcodes";
        return view('adminbizness.discountcodes.edit',compact(['discountcode','Active_list','Active']));
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

        $this->validate($request, [
            'code' => 'required|unique:discountcodes,code,' . $id,
            'darsad' => 'required',
            'max' => 'required',
            'end_date' => 'required',
        ], [
            'code.required'=>'فیلد کد نمی تواند خالی باشد',
            'darsad.required'=>'فیلد درصد تخفیف نمی تواند خالی باشد',
            'max.required'=>'فیلد تعداد قابل استفاده نمی تواند خالی باشد',
        ]);
        $code=Discountcode::findorfail($id);
        $code->code=$request->code;
        $code->darsad=$request->darsad;
        $code->max=$request->max;
        $code->end_date=$request->end_date;
        $code->save();
        session()->put('code-create','کد تخفیف  با موفقیت ویرایش شد');
        return redirect('/admin/discountcodes');
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
