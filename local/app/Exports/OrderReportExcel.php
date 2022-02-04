<?php

namespace App\Exports;

use App\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class OrderReportExcel implements FromView
{
    public function view(): View
    {

        $orders = Order::all();
        return view('adminbizness.orders.report', compact(['orders']));

    }
}
