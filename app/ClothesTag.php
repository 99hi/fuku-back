<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClothesTag extends Model
{
    //
    protected $table = 'clothes_tag';
    protected $fillable = ['clothes_id', 'tag_id'];
}
