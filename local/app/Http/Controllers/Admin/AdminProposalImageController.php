<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Proposalimage;
use App\Sgallery;
use App\Gallery;
use App\Postcategory;
use Gate;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use mysql_xdevapi\Session;

class AdminProposalImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('Proposal-image'),403,'شما به این بخش دسترسی ندارید');
        $Proposals = Proposalimage::all();
        $Active_list="tool";
        $Active="Proposal-image";
        return view('adminbizness.Proposal_image.index',compact('Proposals','Active_list','Active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('Proposal-image'),403,'شما به این بخش دسترسی ندارید');
        $Active_list="tool";
        $Active="Proposal-image";
        return view('adminbizness.Proposal_image.create', compact(['Active_list','Active']));
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
            'image' => 'required',
        ], [
            'image.required'   => 'تصویر خود را انتخاب کنید',
        ]);
        $Proposalimage = new Proposalimage();
        $Proposalimage->title = $request->input('title');
        $Proposalimage->Content = $request->input('content');
        $Proposalimage->status = $request->input('status');

        $file = $request->file('image');
        if($file){
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(1349, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $Proposalimage->image = "images/".Auth::id().'/'.$name;
        }

        $Proposalimage->save();

        //////////////////////////// upload image ///////////////////////////////

        //////////////////////////// upload image ///////////////////////////////


        Session()->put('posts-create','بنر شما با موفقیت ایجاد شد');
        return redirect('/admin/Proposal-image');
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
        abort_unless(Gate::allows('Proposal-image'),403,'شما به این بخش دسترسی ندارید');
        $Proposal=Proposalimage::findorfail($id);
        $Active_list="tool";
        $Active="Proposal-image";
        return view('adminbizness.Proposal_image.edit', compact(['Proposal','Active_list','Active']));
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

        $Proposalimage =Proposalimage::findorfail($id);

        $Proposalimage->title = $request->input('title');
        $Proposalimage->Content = $request->input('content');
        $Proposalimage->status = $request->input('status');

        $file = $request->file('image');
        if($file){
            if ($Proposalimage->image!=""){
                if(file_exists(public_path() . '/' . $Proposalimage->image)) {
                    unlink(public_path($Proposalimage->image));
                }
            }

            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(1349, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $Proposalimage->image = "images/".Auth::id().'/'.$name;
        }

        $Proposalimage->save();

        Session()->put('posts-create','بنر شما با موفقیت ویرایش شد');
        return redirect('/admin/Proposal-image');
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
