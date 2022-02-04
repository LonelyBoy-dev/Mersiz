<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands=Brand::all();
        $Active_list="tool";
        $Active="brands";
        return view('adminbizness.brands.index',compact(['brands','Active_list','Active']));
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
        $this->validate($request, [
            'image' => 'required',
        ], [
            'image.required'=>'عکس مورد نظر خود را انتخاب کنید'
        ]);
        $file = $request->file('image');
        if($file){
            $slider=new Brand();
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/brands/')){
                mkdir("images/brands/");
            }
            $image->save('images/brands/'. $name);

            ///////////// save image in table /////////////
            $slider->imgName = $file->getClientOriginalName();
            $slider->imgPath = "images/brands/".$name;
            $slider->save();
        }
        session()->put('img-create','تصویر شما با موفقیت آپلود شد');
        return redirect('/admin/brands');
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
