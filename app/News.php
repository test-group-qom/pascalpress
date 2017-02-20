<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public function newsdetail()
    {
        return $this->hasMany('App\NewsDetail');
    }
}
