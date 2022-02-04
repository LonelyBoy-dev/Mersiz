<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postcategory extends Model
{
    public function post()
    {
        return $this->belongsToMany(Post::class);
    }
}
