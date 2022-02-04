<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute_product extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
