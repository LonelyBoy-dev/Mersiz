<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Permission;
use App\Permission_role;
use App\Role_user;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('admins_index'),403,'شما به این بخش دسترسی ندارید');
        $users=User::where('role','!=','0')->get();

        $Active_list="tool";
        $Active="admins";
        return view('adminbizness.Admins.index',compact(['users','Active_list','Active']));
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
        $Role_user=Role_user::where('user_id',$request->user_id)->first();
        if (!empty($Role_user)){
            $Role_user->user_id=$request->user_id;
            $Role_user->role_id=$request->user_id;
            $Role_user->save();
        }else{
            $Role_user=new Role_user();
            $Role_user->user_id=$request->user_id;
            $Role_user->role_id=$request->user_id;
            $Role_user->save();
        }

        Permission_role::where('user_id',$request->user_id)->delete();
        if ($request->permission) {
        foreach ($request->permission as $permission){
            $Permission_role=new Permission_role();
            $Permission_role->permission_id=$permission;
            $Permission_role->role_id=$request->user_id;
            $Permission_role->user_id=$request->user_id;
            $Permission_role->save();
        }
        }
        session()->put('Permission','دسترسی ها با موفقیت ثبت شدند');
        return redirect('/admin/admins/'.$request->user_id.'/edit');
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
        if ($id!=1){
            abort_unless(Gate::allows('admins_edit'),403,'شما به این بخش دسترسی ندارید');
            $user=User::where('id',$id)->where('role','!=','0')->first();
            $permissions=Permission::where('parent','0')->get();

            $Active_list="tool";
            $Active="admins";
            return view('adminbizness.Admins.edit',compact(['user','permissions','Active_list','Active']));
        }else{
            abort_unless(Gate::allows('a'),403,'شما به این بخش دسترسی ندارید');
        }

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
