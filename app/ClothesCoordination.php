<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClothesCoordination extends Model
{
    //
    public $timestamps = false;

    protected $table = 'clothes_coordinations';
    protected $fillable = ['coordinations_id', 'clothes_id', 'x', 'y', 'width', 'height'];
}
