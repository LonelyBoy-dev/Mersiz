<?php

namespace App\Http\Controllers\Admin;

use App\Request_quantity;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRequestQuantityController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('RequestQuantity'),403,'شما به این بخش دسترسی ندارید');
        $RequestQuantities=Request_quantity::with('product')->orderby('count','desc')->get();
        $Active_list="products";
        $Active="RequestQuantity";
        return view('adminbizness.RequestQuantity.index', compact(['RequestQuantities','Active_list','Active']));
    }
}
