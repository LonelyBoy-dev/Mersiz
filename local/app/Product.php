<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Gallery;
use App\Feature;

class Product extends Model
{
    protected $fillable = ['product_id','title','unit','price','depot','user_id','slug','status'];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attribute_products()
    {
        return $this->belongsToMany(Attribute_product::class);
    }



    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
