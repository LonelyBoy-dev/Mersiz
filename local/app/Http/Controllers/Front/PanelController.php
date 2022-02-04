<?php

namespace App\Http\Controllers\Front;

use App\Address;
use App\Comment;
use App\Complain;
use App\Favorite;
use App\Message;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\Barcode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PanelController extends Controller
{
    public function index()
    {
        $title='حساب کاربری';
        $seo_title="سئو پروفایل";
        $seo_content="سئو پروفایل";
        $user=User::findorfail(Auth::id());
        return view('front.profile.index',compact(['user','title','seo_title','seo_content']));
    }
    public function orders()
    {
        $title='سابقه خرید';
        $seo_title="سئو سابقه خرید";
        $seo_content="سئو سابقه خرید";
        $orders = Order::where(['user_id'=> Auth::id()])->select('factor_number', 'user_id', 'pay_status')->distinct()->orderby('factor_number','desc')->paginate(21);
        return view('front.profile.orders',compact(['orders','title','seo_title','seo_content']));
    }
    public function orders_show($factor_id)
    {
        $title='جزئیات سفارش';
        $seo_title="سئو جزئیات خرید";
        $seo_content="سئو جزئیات خرید";
        $orders = Order::where('factor_number', $factor_id)->get();
        return view('front.profile.order-show',compact(['orders','title','seo_title','seo_content']));
    }
    public function orders_show_invoice($factor_id)
    {
        $title='جزئیات سفارش';
        $seo_title="سئو جزئیات خرید";
        $seo_content="سئو جزئیات خرید";
        $orders = Order::where('factor_number', $factor_id)->get();
        $barcode_generator= new BarcodeGeneratorPNG();
        $barcode=$barcode_generator->getBarcode($orders[0]->factor_number,$barcode_generator::TYPE_CODE_128);
        return view('front.profile.invoice',compact(['orders','title','seo_title','seo_content','barcode']));
    }
    public function favorites()
    {
        $favorites=Favorite::with('product')->where('user_id',Auth::id())->get();
        return view('front.profile.favorites',compact(['favorites']));
    }
    public function comments()
    {
        $title='نظرات من';
        $seo_title="سئو نظرات من";
        $seo_content="سئو نظرات من";
        $comments=Comment::with('product')->where('user_id',Auth::id())->orderBy('id','DESC')->paginate(10);
        return view('front.profile.comments',compact(['comments','title','seo_title','seo_content']));
    }
    public function address()
    {
        $title='آدرس های من';
        $seo_title="سئو آدرس های من";
        $seo_content="سئو آدرس های من";
        $addresses=Address::where('user_id',Auth::id())->get();
        return view('front.profile.address',compact(['addresses','title','seo_title','seo_content']));
    }

    public function saveaddresse(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'plaque' => 'required',
        ], [

        ]);
        if ($request->status=="insert") {
            $address=new Address();
            $address->user_id=Auth::id();
            $address->name=$request->name;
            $address->mobile=$request->mobile;
            $address->address=$request->address;
            $address->plaque=$request->plaque;
            $address->location=$request->Map;
            $address->unit=$request->unit;
            $address->postal_code=$request->postalcode;
            if ($request->back_url) {
                Address::where('user_id',Auth::id())->update(['selected'=>"NO"]);
                $address->selected="YES";
            }
            $address->save();
            session()->put('save_address','آدرس جدید با موفقیت ثبت شد');
        }elseif ($request->status=="update"){
            $address=Address::where(['user_id'=>Auth::id(),'id'=>$request->data_id])->first();
            $address->name=$request->name;
            $address->mobile=$request->mobile;
            $address->address=$request->address;
            $address->plaque=$request->plaque;
            $address->location=$request->Map;
            $address->unit=$request->unit;
            $address->postal_code=$request->postalcode;
            $address->save();
            session()->put('save_address_update','آدرس شما با موفقیت ویرایش شد');
        }
        if ($request->back_url) {
            return redirect($request->back_url);
        }else{
            return redirect('/profile/address');
        }


    }
    public function invitefriends()
    {
        $title='لینک بازاریابی من';
        $seo_title="سئو لینک بازاریابی من";
        $seo_content="سئو لینک بازاریابی من";
        $user=User::with('orders')->where('id',Auth::id())->first();
        return view('front.profile.invitefriends',compact(['user','title','seo_title','seo_content']));
    }
    public function bankcard()
    {
        $user=User::find(Auth::id());
        return view('front.profile.bankcard',compact(['user']));
    }
    public function bankcard_store(Request $request)
    {
        $this->validate($request, [
            'CodePart1' => 'required',
            'CodePart2' => 'required',
            'CodePart3' => 'required',
            'CodePart4' => 'required',
        ], [
            'CodePart1.required' => ' شماره کارت ضروری است',
            'CodePart2.required' => ' شماره کارت ضروری است',
            'CodePart3.required' => ' شماره کارت ضروری است',
            'CodePart4.required' => ' شماره کارت ضروری است',
        ]);
        $user=User::find(Auth::id());
        $user->card_number=$request->CodePart1.'-'.$request->CodePart2.'-'.$request->CodePart3.'-'.$request->CodePart4;
        $user->save();
        session()->put('bankcard_store','شماره کارت بانکی شما با موفقیت ثبت شد');
        return redirect('/profile/bankcard');
    }
    public function complain()
    {
        $title='شکایات و پیشنهادات';
        $seo_title="سئو شکایات و پیشنهادات";
        $seo_content="سئو شکایات و پیشنهادات";
        $complains=Complain::where('user_id',Auth::id())->get();
        return view('front.profile.complain',compact(['complains','title','seo_title','seo_content']));
    }
    public function messages()
    {
        $title='پیام ها';
        $seo_title="سئو پیام ها";
        $seo_content="سئو پیام ها";
        $messages=Message::where('status','Show')->get();
        return view('front.profile.messages',compact(['messages','title','seo_title','seo_content']));
    }
    public function complain_store(Request $request)
    {
        $this->validate($request, [
            'CaseTypeCode' => 'required',
            'title' => 'required',
            'MessageDescription' => 'required',
        ], [
            'CaseTypeCode.required' => ' نوع درخواست ضروری است',
            'title.required' => ' عنوان ضروری است',
            'MessageDescription.required' => ' متن ضروری است',
        ]);
        $complain=new Complain();
        $complain->CaseTypeCode=$request->CaseTypeCode;
        $complain->title=$request->title;
        $complain->Message=$request->MessageDescription;
        $complain->user_id=Auth::id();
        $complain->save();
        if ($request->CaseTypeCode=="درخواست") {
            session()->put('complain__store','سوال شما با موفقیت ثبت شد، و پس از برسی به شما پاسخ داده می شود.');
        }
        if ($request->CaseTypeCode=="شکایت") {
            session()->put('complain__store','شکایت شما با موفقیت ثبت شد');
        }
        if ($request->CaseTypeCode=="پیشنهاد/انتقاد") {
            session()->put('complain__store','پیشنهاد شما با موفقیت ثبت شد');
        }
        if ($request->CaseTypeCode=="درخواست") {
            session()->put('complain__store','درخواست شما با موفقیت ثبت شد');
        }
        return redirect('/profile/complain');
    }
    public function profile()
    {
        $user=User::findorfail(Auth::id());
        return view('front.profile.profile',compact(['user']));
    }

    public function edit_profile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'family' => 'required',
            'email' => 'nullable|email|unique:users,mobile,' . Auth::id(),
        ], [
            'name.required' => ' نام ضروری است',
            'family.required' => ' خانوادگی ضروری است',
            'email.unique' => 'ایمیل از قبل موجود است',
            'email.email' => 'ایمیل صحیح نیست',

        ]);
        $user=User::findorfail(Auth::id());
        $user->name=$request->name;
        $user->sex=$request->sex;
        $user->family=$request->family;
        $user->email=$request->email;
        $user->birthday=$request->birthday;
        $user->save();

        session()->put('edit_profile','اطلاعات شما با موفقیت ویرایش شد');
        return redirect('/profile');
    }
}
