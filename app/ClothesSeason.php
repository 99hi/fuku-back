<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClothesSeason extends Model
{
    //
    protected $table = 'clothes_seasons';
    protected $fillable = ['clothes_id', 'seasons_id'];
}
