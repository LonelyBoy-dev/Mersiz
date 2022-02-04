<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
