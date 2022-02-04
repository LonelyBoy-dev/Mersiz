<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Gate;
use Illuminate\Support\Facades\Auth;

class AdminCommentProductController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('products_comment'),403,'شما به این بخش دسترسی ندارید');
        $comments = Comment::with('user')->with('product')->where('parent','0')->paginate(15);

        $Active_list="products";
        $Active="comment";
        return view('adminbizness.comment_product.index',compact('comments','Active_list','Active'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Comment::where('id',$request->answer_id)->update(['status'=>'SEEN']);
        $Service_comments=new Comment();
        $Service_comments->content=$request->content1;
        $Service_comments->parent=$request->answer_id;
        $Service_comments->product_id=$request->product_id;
        $Service_comments->status="SEEN";
        $Service_comments->user_id=Auth::id();
        $Service_comments->save();

        session()->put('answer-success','جواب شما با موفقیت ثبت شد و در بخش نظرات فعال شد');
        return redirect('/admin/comment-product');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
