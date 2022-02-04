<?php

namespace App;

use App\Model\Role;
use App\Permission_role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function Permission_role()
    {
        return $this->hasone(Permission_role::class);
    }
/*    public function Permission_role()
    {
        return $this->belongsTo(Permission_role::class);
    }*/
}
