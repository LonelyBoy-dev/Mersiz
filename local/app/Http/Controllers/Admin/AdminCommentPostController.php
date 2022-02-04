<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Post_comments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminCommentPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('comment_services_index'),403,'شما به این بخش دسترسی ندارید');
        $comments=Post_comments::with('user')->with('post')->where('parent','0')->paginate(15);
        $Active_list="blog";
        $Active="comment_services";
        return view('adminbizness.comment_post.index',compact('comments','Active_list','Active'));
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
        Post_comments::where('id',$request->answer_id)->update(['status'=>'SEEN']);
        $Service_comments=new Post_comments();
        $Service_comments->content=$request->input('content');
        $Service_comments->parent=$request->answer_id;
        $Service_comments->service_id=$request->service_id;
        $Service_comments->status="SEEN";
        $Service_comments->user_id=Auth::id();
        $Service_comments->save();

        session()->put('answer-success','جواب شما با موفقیت ثبت شد و نظر نمایش داده شد');
        return redirect('/adminb/comment-service');
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
