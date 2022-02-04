<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\Http\Requests\ServiceRequest;
use App\Page;
use App\Post;
use App\Postcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdminPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('pages_index'),403,'شما به این بخش دسترسی ندارید');
        $pages = Page::orderby('id','desc')->get();
        return view('adminbizness.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('post_create'),403,'شما به این بخش دسترسی ندارید');
        return view('adminbizness.pages.create');
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
            'title' => 'required|min:3',
            'slug' => 'required|min:3|unique:pages',
            'page' => 'required',
            'seoTitle' => 'required|min:3',
        ], [
            'title.required'   => 'وارد کردن عنوان الزامی می باشد.',
            'title.min'   => 'حداقل عنوان 3 کاراکتر می باشد',
            'slug.min'   => 'حداقل نامک 3 کاراکتر می باشد',
            'slug.required'   => 'وارد کردن نامک الزامی می باشد.',
            'slug.unique'   => 'نامک از قبل وجود دارد',
            'page.required'   => 'وارد کردن صفحه الزامی می باشد.',
            'seoTitle.required'   => 'وارد کردن عنوان سئو الزامی می باشد.',
            'seoTitle.min'   => 'حداقل عنوان سئو 3 کاراکتر می باشد',
        ]);


        $page=new Page();
        $page->title=$request->title;
        if ($request->slug == "") {
            $temp = str_replace(" ", "-", $request->title);
            $page->slug = $temp;
        } else {
            $page->slug = $request->input('slug');
        }        $page->seoTitle=$request->seoTitle;
        $page->seoContent=$request->seoContent;
        $page->page=$request->page;
        $page->save();
        Session()->put('posts-create','صفحه شما با موفقیت ایجاد شد');
        return redirect('/admin/pages');
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
        abort_unless(Gate::allows('post_edit'),403,'شما به این بخش دسترسی ندارید');
        $page=Page::findorfail($id);
        return view('adminbizness.pages.edit', compact(['page']));
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
            'title' => 'required|min:3',
            'slug' => 'required|min:3|unique:pages,id,'.$id,
            'page' => 'required',
            'seoTitle' => 'required|min:3',
        ], [
            'title.required'   => 'وارد کردن عنوان الزامی می باشد.',
            'title.min'   => 'حداقل عنوان 3 کاراکتر می باشد',
            'slug.min'   => 'حداقل نامک 3 کاراکتر می باشد',
            'slug.required'   => 'وارد کردن نامک الزامی می باشد.',
            'slug.unique'   => 'نامک از قبل وجود دارد',
            'page.required'   => 'وارد کردن صفحه الزامی می باشد.',
            'seoTitle.required'   => 'وارد کردن عنوان سئو الزامی می باشد.',
            'seoTitle.min'   => 'حداقل عنوان سئو 3 کاراکتر می باشد',
        ]);
        $page=Page::find($id);
        $page->title=$request->title;
        $page->slug=$request->slug;
        $page->seoTitle=$request->seoTitle;
        $page->seoContent=$request->seoContent;
        $page->page=$request->page;
        $page->save();
        Session()->put('posts-create','صفحه شما با موفقیت ویرایش شد');
        return redirect('/admin/pages');
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
