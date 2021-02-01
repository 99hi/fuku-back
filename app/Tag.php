<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $hidden = ['pivot'];
    protected $fillable = ['user_id', 'name', 'which'];
    public $timestamps = false;
    //
    public function clothes()
    {
        return $this->belongsToMany('App\Clothes', 'clothes_tag');
    }
}
