<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request_quantity extends Model
{
    protected $table='request_quantitys';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
