<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CoordinationsTag extends Pivot
{
    protected $table = 'coordinations_tag';
    protected $fillable = ['coordinations_id', 'tag_id'];
}
