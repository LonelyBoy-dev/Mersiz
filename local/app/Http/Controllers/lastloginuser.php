<?php

namespace App\Http\Controllers;

use App\Infousr;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class lastloginuser extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 1){
            $lastlogin = Infousr::where('product_id', null)->orderby('id', 'desc')->paginate(40);
            return view('adminbizness.lastlogin.index', compact(['lastlogin']));
        }else{
            $lastlogin = Infousr::where('user_id', Auth::id())->orderby('id', 'desc')->paginate(10);
            return view('adminbizness.lastlogin.index', compact(['lastlogin']));
        }
    }
    public function stats()
    {
        $stats = Infousr::where('user_id', null)->orderby('id', 'desc')->paginate(20);
        $total_view = Product::sum('userview');
//        $total_view_today = Product::where('created_at', Carbon::today())->sum('userview');
//        $total_view_yesterday = Product::where('dateme', Carbon::yesterday()->format('Y-m-d'))->sum('userview');
        $total_ip = Product::sum('userip');
        $total_mobile = Infousr::where(['user_id' => null, 'device' => 'Mobile'])->get();
        $total_computer = Infousr::where(['user_id' => null, 'device' => 'Computer'])->get();
        return view('adminbizness.stats.index', compact(['stats', 'total_view', 'total_ip', 'total_mobile', 'total_computer']));
    }
}
