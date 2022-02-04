<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\userinforeport;
use App\Infousr;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request)
    {
        if( Auth::user()->status == 'INACTIVE'){
            Auth::logout();
            session()->put('Access', 'NOT');
            return redirect('login');
        }
        $infouser = new Infousr();
        $infouser->user_id = Auth::id();
        $infouser->ip = userinforeport::get_ip();
        $infouser->os = userinforeport::get_os();
        $infouser->device = userinforeport::get_device();
        $infouser->browser = userinforeport::get_browser();
        $infouser->save();


    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
