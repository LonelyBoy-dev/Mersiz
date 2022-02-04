<?php

namespace App\Exports;

use App\Order;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class UserReportExcel implements FromView
{
    public function view(): View
    {

        $users = User::where('role','0')->get();
        return view('adminbizness.users.report', compact(['users']));

    }
}
