<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminBannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::all();

        $Active_list="tool";
        $Active="banners";
        return view('adminbizness.banners.index',compact(['banners','Active_list','Active']));
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
        $this->validate($request, [
            'image' => 'required',
        ], [
            'image.required'=>'عکس مورد نظر خود را انتخاب کنید'
        ]);
        $file = $request->file('image');
        if($file){
            $slider=new Banner();
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            /*$image->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });*/
            if(!is_dir('images/banner/')){
                mkdir("images/banner/");
            }
            $image->save('images/banner/'. $name);

            ///////////// save image in table /////////////
            $slider->imgName = $file->getClientOriginalName();
            $slider->imgPath = "images/banner/".$name;
            $slider->save();
        }
        session()->put('img-create','تصویر شما با موفقیت آپلود شد');
        return redirect('/admin/banners');
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
