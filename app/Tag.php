<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $hidden = ['pivot'];
    public $timestamps = false;
    //
    public function clothes()
    {
        return $this->belongsToMany('App\Clothes', 'clothes_tag');
    }
}
