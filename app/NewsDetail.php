<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsDetail extends Model
{
    use SoftDeletes;
	
	public function News(){ 
		return $this->belongsto(News::class);
	}
}
