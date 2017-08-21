<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
	use SoftDeletes;
	protected $fillable = [
		'admin',
		'name',
		'username',
		'password',
		'email',
		'mobile',
		'status',
	];
	protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
	protected $hidden = [ 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at' ];

	public function isAdmin() {
		if($this->id === 1 && $this->admin === 1){
			return true;
		}
		//$type = ( $this->admin === 1 ) ? true : false;

		return false;
	}
}
