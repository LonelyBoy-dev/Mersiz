<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Spacial;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSpecialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('special'),403,'شما به این بخش دسترسی ندارید');
        $spacials=Product::where(['day_basket'=>'YES','status'=> 'PUBLISHED'])->get();
        $spacial=Spacial::where('id','1')->first();

        $Active_list="products";
        $Active="special";
        return view('adminbizness.special.index',compact(['spacials','spacial','Active_list','Active']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $spacial=Spacial::where('id','1')->first();
        if (!empty($spacial)){
            $spacial->date=$request->date;
            $spacial->time=$request->time;
            $spacial->save();
        }else{
            $spacial=new Spacial();
            $spacial->date=$request->date;
            $spacial->time=$request->time;
            $spacial->save();
        }
        session()->put('spacial-create','زمان شما با موفقیت تنظیم شد');
        return redirect('/admin/special');
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
