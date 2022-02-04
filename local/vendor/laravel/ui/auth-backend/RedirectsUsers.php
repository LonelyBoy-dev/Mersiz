<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Support\Facades\Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        $user=User::findorfail(Auth::id());
        if ($user->role != 0){
            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin/dashboard';
        }else{
            if(session('back'))
            {
                return property_exists($this, 'redirectTo') ? $this->redirectTo : session('back')['url.intended'];
            }else{
                return property_exists($this, 'redirectTo') ? $this->redirectTo : '/profile';
            }
        }
        //return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
