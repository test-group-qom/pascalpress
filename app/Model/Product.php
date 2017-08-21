<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
	use SoftDeletes;
	protected $fillable = [ 'title', 'thumb', 'content', 'visit', 'status' ];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'updated_at', 'deleted_at' ];

	public function productCat() {
		return $this->belongsToMany( Category::class, 'post_categories', 'post_id', 'cat_id' )->withTimestamps();
	}
}
