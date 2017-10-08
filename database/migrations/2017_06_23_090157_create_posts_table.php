<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'posts', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'title' );
			$table->string( 'thumb' )->nullable();
			$table->string( 'excerpt' )->nullable();
			$table->longText( 'content' );
			$table->integer( 'post_type' )->default( 0 );
			$table->integer( 'visit' )->default( 0 );
			$table->integer( 'status' )->default( 1 );
			$table->text('specs')->nullable();
			$table->text('property')->nullable();
			$table->text('files')->nullable();
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
		Schema::dropIfExists( 'posts' );
	}
}
