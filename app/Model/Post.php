<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {
	use SoftDeletes;
	protected $fillable = [
		'title',
		'thumb',
		'excerpt',
		'content',
		'post_type',// 0 = article , 1 = page , 2 = product
		'visit',
		'status',
		//---------- just for products
		'specs',
		'property',
		'files',
		//----------
	];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'updated_at', 'deleted_at' ];
	
	protected $casts = [ 'specs' => 'array', 'property' => 'array', 'files' => 'array' ];

	public function category() {
		return $this->belongsToMany( Category::class, 'post_categories', 'post_id', 'cat_id' )->withTimestamps();
	}

	public function tags() {
		return $this->belongsToMany( Tag::class, 'post_tags', 'post_id', 'tag_id' )->withTimestamps();
	}

}
