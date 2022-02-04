<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function postcategories()
    {
        return $this->belongsToMany(Postcategory::class);
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }
    public function scopeFilter($q)
    {
        if (request('state')) {
            $q->where('state', '=', request('state'));
        }
        if (request('city')) {
            $q->where('city', '=', request('city'));
        }

        return $q;
    }
}
