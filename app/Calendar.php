<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    public function coordination()
    {
        return $this->belongsTo('App\Coordination', 'coordinations_id');
    }
}
