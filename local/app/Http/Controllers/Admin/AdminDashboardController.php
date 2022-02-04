<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Post;
use App\Product;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Miniproduct;
use Illuminate\Support\Facades\Cookie;
use Shetabit\Visitor\Models\Visit;


class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allvisits=Visit::all();
        $uservisits=Visit::select('visitor_id')->distinct()->get();
        $date_now=now()->format('Y-m-d');
        $v=verta();
        $allvisits_days=Visit::where('date_day',$v->format('d'))->get();
        $uservisits_day=Visit::where('created_at','like',"%".$date_now."%")->select('visitor_id')->distinct()->get();
        $posts = Post::with('postcategories')->orderby('id','desc')->take(5)->get();
        $visits=Visit::paginate(10);

        $today_date = date('Y/m/d');
        $time = time();
        $last_week_time = $time - (7 * 24 * 3600);
        $last_week_date = date('Y/m/d', $last_week_time);
        $dates = array();
        $current = strtotime($last_week_date);
        $last = strtotime($today_date);
        $orderStat=[];
        while ($current <= $last) {
            $dates[] = date('Y/m/d', $current);
            $dates2[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }
        $sevendate=[];
        foreach ($dates as $date) {
            $sevendate[]=Verta::instance($date)->format('Y/m/d');
            $te=Verta::instance($date)->format('Y/m/d');
            $orderStat[$te] = 0;
        }

        $orders_dates=Order::where('pay_status','OK')->select('factor_number', 'user_id', 'pay_status')->distinct()->get();
        foreach ($orders_dates as $order_date){
            $order_date=Order::where('factor_number',$order_date->factor_number)->first();
            $dateOrder=Verta::instance($order_date->created_at)->format('Y/m/d');
            //$orders_dates[]=Order::where('created_at','like','%'.$order_date.'%')->where('pay_status','OK')->get();
            if (in_array($dateOrder, $sevendate)) {
                $orderStat[$dateOrder] = $orderStat[$dateOrder] + 1;

            }

        }

        $values=implode(',',$orderStat);
        $orders=Order::where('pay_status','OK')->select('factor_number', 'user_id', 'pay_status')->distinct()->orderby('factor_number','desc')->take(8)->get();
        $sale_product = Product::where('status', 'PUBLISHED')->orderby('sale', 'desc')->take(10)->get();
        $products_view = Product::where('status', 'PUBLISHED')->orderby('view', 'desc')->take(10)->get();
        $products_new = Product::where('status', 'PUBLISHED')->orderby('id', 'desc')->take(5)->get();

        $Active="dashboard";
        return view('adminbizness.dashboard.index',compact(['Active','posts','allvisits','uservisits','allvisits_days','uservisits_day','sevendate','orders','values','sale_product','products_view','products_new','visits']));
    }

    public function delete_views()
    {
        Visit::truncate();
        session()->put('deleteView','بازدید ها با موفقیت حذف شدند.');
        return redirect('/admin/dashboard');
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
        //
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
