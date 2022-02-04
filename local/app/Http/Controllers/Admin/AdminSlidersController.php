<?php

namespace App\Http\Controllers\Admin;

use App\Slider;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdminSlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('slider'),403,'شما به این بخش دسترسی ندارید');
        $sliders=Slider::all();

        $Active_list="tool";
        $Active="sliders";
        return view('adminbizness.sliders.index',compact(['sliders','Active_list','Active']));
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
            $slider=new Slider();
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            /*$image->resize(970, null, function ($constraint) {
                $constraint->aspectRatio();
            });*/
            $image->resize(970, '', function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/slider/')){
                mkdir("images/slider/");
            }
            $image->save('images/slider/'. $name);

            ///////////// save image in table /////////////
            $slider->imgName = $file->getClientOriginalName();
            $slider->imgPath = "images/slider/".$name;
            $slider->save();
        }
        session()->put('img-create','تصویر شما با موفقیت آپلود شد');
        return redirect('/admin/sliders');
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
