<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use App\Gallery;
use App\Http\Requests\ServiceRequest;
use App\Post;
use Gate;
use App\Postcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('post_index'),403,'شما به این بخش دسترسی ندارید');
        $faqs = Faq::all();
        $Active_list="other_page";
        $Active="faq";
        return view('adminbizness.faq.index',compact('faqs','Active_list','Active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('faq_create'),403,'شما به این بخش دسترسی ندارید');
        $categories = Postcategory::all();
        return view('adminbizness.faq.create', compact(['categories']));
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
            'Question' => 'required|string|min:3',
            'Answer' => 'required|string|min:3',
        ], [
            'Question.required' => 'وارد کردن عنوان سوال الزامی می باشد.',
            'Answer.required' => 'وارد کردن جواب سوال الزامی می باشد.',
        ]);
        $faq = new Faq();
        $faq->Question = $request->input('Question');
        $faq->Answer = $request->input('Answer');
        $faq->status = $request->input('status');
        $faq->save();
        Session()->put('posts-create','سوالات شما با موفقیت ایجاد شد');
        return redirect('/admin/faq');
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
        abort_unless(Gate::allows('faq_edit'),403,'شما به این بخش دسترسی ندارید');
        $faq=Faq::find($id);
        return view('adminbizness.faq.edit', compact(['faq']));
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
        $this->validate($request, [
            'Question' => 'required|string|min:3',
            'Answer' => 'required|string|min:3',
        ], [
            'Question.required' => 'وارد کردن عنوان سوال الزامی می باشد.',
            'Answer.required' => 'وارد کردن جواب سوال الزامی می باشد.',
        ]);
        $faq =Faq::findorfail($id);
        $faq->Question = $request->input('Question');
        $faq->Answer = $request->input('Answer');
        $faq->status = $request->input('status');
        $faq->save();
        Session()->put('posts-create','سوالات شما با موفقیت ویرایش شد');
        return redirect('/admin/faq');
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
