<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsDetails extends Model
{
    use SoftDeletes;
	
	public function News(){
		return $this->belongsto(News::class);
	}
}
