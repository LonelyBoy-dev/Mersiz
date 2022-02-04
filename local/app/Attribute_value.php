<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute_value extends Model
{
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
