<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function surface()
    {
        return $this->belongsTo(Surface::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
