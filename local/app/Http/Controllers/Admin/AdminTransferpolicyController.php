<?php

namespace App\Http\Controllers\Admin;

use App\About;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTransferpolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('returnpolicy'),403,'شما به این بخش دسترسی ندارید');
        $about=About::find(4);
        $Active_list="other_page";
        $Active="transferpolicy";
        return view('adminbizness.transferpolicy.index',compact('about','Active_list','Active'));
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
        $about=About::find(4);
        $about->content=$request->input('content');
        $about->save();
        Session()->put('posts-create','صفحه شرایط حمل و نقل با موفقیت ویرایش شد');
        return redirect('/admin/transferpolicy');
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
