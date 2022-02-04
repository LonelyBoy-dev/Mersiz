<?php

namespace App;

use App\Listpeople;
use App\Userrequest;
use App\Presence;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Shetabit\Visitor\Traits\Visitor;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,Visitor;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password','mobile', 'email','family',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        $roles=Role::all();
        foreach ($roles as $role){
                if ($role->id==1 or $role->id==0){
                    return true;
                }
        }
        return false;
    }


}
