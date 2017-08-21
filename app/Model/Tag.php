<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model {
	use SoftDeletes;
	protected $fillable = [ 'name'];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'created_at', 'updated_at', 'deleted_at' ];

	public function posts() {
		return $this->belongsToMany( Post::class, 'post_tags', 'tag_id', 'post_id' )->withTimestamps();
	}
}
