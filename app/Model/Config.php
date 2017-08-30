<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model {
	use SoftDeletes;
	protected $fillable = [ 'title', 'description', 'keyword', 'copyright', 'info'];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'created_at', 'updated_at', 'deleted_at' ];
}
