<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    protected $hidden = ['pivot'];
    //
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'clothes_tag', 'clothes_id');
    }

    public function seasons()
    {
        return $this->belongsToMany('App\Season', 'clothes_seasons');
    }

    public function coordinations()
    {
        return $this->belongsToMany('App\Coordination', 'clothes_coordinations', 'clothes_id', 'coordinations_id');
    }
}
