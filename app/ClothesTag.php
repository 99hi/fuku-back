<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClothesTag extends Pivot
{
    //
    protected $table = 'clothes_tag';
    protected $fillable = ['clothes_id', 'tag_id'];
}
