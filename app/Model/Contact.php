<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
	use SoftDeletes;
	protected $fillable = [ 'name', 'email', 'mobile', 'message' ];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'created_at', 'updated_at', 'deleted_at' ];
}
