<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriesProductCreateRequest;
use App\Http\Requests\CategoriesProductEditRequest;
use App\Http\Controllers\Controller;
use App\Category;
use Gate;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Attribute;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('products_category'),403,'شما به این بخش دسترسی ندارید');
        $categories = Category::all();

        $Active_list="products";
        $Active="category";
        return view('adminbizness.categories.index', compact('categories','Active_list','Active'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $Active_list="products";
        $Active="category";
        return view('adminbizness.categories.create', compact(['categories','Active_list','Active']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesProductCreateRequest $request)
    {
        $category = new Category();
        $category->title = $request->title;
        $category->parent = $request->parent;
        $category->showindex = $request->showindex;
        $category->status = $request->status;

        if($request->input('slug')){
            $category->slug = make_slug($request->input('slug'));
        }else{
            $category->slug = make_slug($request->input('title'));
        }

        $file = $request->file('image');
        if($file){

            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $category->imgName = $file->getClientOriginalName();
            $category->imgPath = "images/".Auth::id().'/'.$name;
        }

        $category->save();
        session()->put('categories-create', 'دسته بندی مورد نظر با موفقیت ثبت شد.');
        return redirect('/admin/categories');
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
    public function edit(Category $category)
    {
        $categories = Category::all();
        $Active_list="products";
        $Active="category";
        return view('adminbizness.categories.edit', compact('categories','category','Active_list','Active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesProductEditRequest $request, Category $category)
    {
        $category->title = $request->title;
        $category->parent = $request->parent;
        $category->slug = $request->slug;
        $category->showindex = $request->showindex;
        $category->status = $request->status;
        $file = $request->file('image');
        if($file){
            if ($category->imgName!=""){
                unlink(public_path($category->imgPath));
            }

            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $category->imgName = $file->getClientOriginalName();
            $category->imgPath = "images/".Auth::id().'/'.$name;
        }
        $category->save();
        session()->put('categories-create', 'دسته بندی مورد نظر با موفقیت بروزرسانی شد.');
        return redirect('/admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->delete()){
            session()->put('delete_category', 'دسته بندی مورد نظر با موفقیت حذف شد');
            return redirect()->back();
        }
    }
}
