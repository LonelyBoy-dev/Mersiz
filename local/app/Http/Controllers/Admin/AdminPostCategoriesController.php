<?php

namespace App\Http\Controllers\Admin;
use App\Postcategory;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPostCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('post_category_index'),403,'شما به این بخش دسترسی ندارید');
        $categories = Postcategory::all();
        $Active_list="blog";
        $Active="post_category";
        return view('adminbizness.PostCategory.index', compact('categories','Active_list','Active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('post_category_create'),403,'شما به این بخش دسترسی ندارید');
        $categories = Postcategory::all();

        $Active_list="blog";
        $Active="post_category";
        return view('adminbizness.PostCategory.create', compact(['categories','Active_list','Active']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Postcategory();
        $category->title = $request->title;
        $category->parent = $request->parent;
        $category->slug = $request->slug;
        $category->save();
        return redirect('/admin/PostCategory');
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
        abort_unless(Gate::allows('post_category_edit'),403,'شما به این بخش دسترسی ندارید');
        $category = Postcategory::findorfail($id);
        $categories = Postcategory::all();

        $Active_list="blog";
        $Active="post_category";
        return view('adminbizness.PostCategory.edit', compact(['category','categories','Active_list','Active']));
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
        $category =Postcategory::findorfail($id);
        $category->title = $request->title;
        $category->parent = $request->parent;
        $category->slug = $request->slug;
        $category->save();
        return redirect('/admin/PostCategory');
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
