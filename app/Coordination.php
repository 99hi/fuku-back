<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordination extends Model
{
    protected $hidden = ['pivot'];
    //
    public function clothes()
    {
        return $this->belongsToMany('App\Clothes', 'clothes_coordinations', 'coordinations_id')
                    ->withPivot('x', 'y', 'width', 'height');
    }

    public function seasons()
    {
        return $this->belongsToMany('App\Season', 'coordinations_seasons', 'coordinations_id', 'seasons_id');
    }
}
