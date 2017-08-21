<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'users', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'admin' )->default( 0 );
			$table->string( 'name' );
			$table->string( 'username' );
			$table->string( 'password' );
			$table->string( 'email' );
			$table->string( 'mobile' )->nullable();
			$table->integer( 'status' )->default( 1 );
			$table->string( 'remember_token' )->nullable();
			$table->timestamps();
			$table->softDeletes();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'users' );
	}

}
