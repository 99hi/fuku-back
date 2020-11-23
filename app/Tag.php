<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    //
    public function clothes()
    {
        return $this->belongsToMany('App\Clothes', 'clothes_tag');
    }
}
