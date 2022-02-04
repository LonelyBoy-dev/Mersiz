<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\Exports\OrderReportExcel;
use Maatwebsite\Excel\Facades\Excel;

class AdminOrdersController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('products_order'),403,'شما به این بخش دسترسی ندارید');
        $orders = Order::where(['reservation'=>'no'])->orderby('created_at','desc')->select('factor_number', 'user_id', 'pay_status','created_at')->distinct()->paginate(20);

        $Active_list="products";
        $Active="orders";
        return view('adminbizness.orders.index', compact(['orders','Active_list','Active']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($factor_number)
    {
        $orders = Order::where(['factor_number' => $factor_number])->get();
        $Active_list="products";
        $Active="orders";
        return view('adminbizness.orders.show', compact(['orders','Active_list','Active']));
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

    public function report()
    {
        return Excel::download(new OrderReportExcel, 'OrderReport.xlsx');
    }
}
