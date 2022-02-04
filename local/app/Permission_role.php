<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_role extends Model
{
    protected $table="permission_role";
    public function permissions()
    {
        return $this->belongsTo(Permission::class);
    }
/*    public function permissions()
    {
        return $this->belongsTo(Permission::class);
    }*/
}
