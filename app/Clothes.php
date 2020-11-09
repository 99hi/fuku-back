<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    //
    public function tags() {
        return $this->belongsToMany('App\Tag', 'clothes_tag');
    }

    public function seasons() {
        return $this->belongsToMany('App\Season', 'clothes_seasons');
    }
}
