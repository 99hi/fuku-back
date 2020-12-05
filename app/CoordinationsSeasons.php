<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoordinationsSeasons extends Model
{
    protected $table = 'coordinations_seasons';
    protected $fillable = ['coordinations_id', 'seasons_id'];
}
