<?php

namespace App\Http\Middleware;

use App\Role;
use App\Permission;
use App\Permission_role;
use Closure;
use Gate;
use Illuminate\Support\Facades\Auth;
use function Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=Auth::user();
        if (!app()->runningInConsole() && $user){
            $roles=Role::with('permissions')->get();
            foreach ($roles as $role){
                foreach ($role->permissions as $permissions){
                    $permissionsArray[$permissions->title][]=$role->id;
                }
            }
            foreach ($permissionsArray as $title=>$roles){
                Gate::define($title,function (\App\User $user) use ($roles){
                    return count(array_intersect($user->roles->pluck('id')->toArray(),$roles))>0;
                });
            }
        }
        return $next($request);
        /*$user=Auth::user();
        if (!app()->runningInConsole() && $user){
            $roles=Permission::with('permission_role')->get();
            foreach ($roles as $role){
                dd($role);


                foreach ($role->permissions as $permissions){
                    $permissionsArray[$permissions->title][]=$role->id;
                }
            }


            foreach ($permissionsArray as $title=>$roles){

                Gate::define($title,function (\App\User $user) use ($roles){
                    return count(array_intersect($user->roles->pluck('id')->toArray(),$roles))>0;
                });
            }
        }
        return $next($request);*/
    }

}
