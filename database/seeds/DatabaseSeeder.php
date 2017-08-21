<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		DB::table( 'categories' )->insert( [
			[
				'name'       => 'دسته بندی نشده',
				'created_at' => Carbon::now()->format( 'Y-m-d H:i:s' ),
				'updated_at' => Carbon::now()->format( 'Y-m-d H:i:s' )
			]
		] );

		DB::table( 'users' )->insert( [
			'admin'      => 1,
			'name'       => 'مدیریت',
			'username'   => 'admin',
			'password'   => bcrypt( 'secret' ),
			'email'      => 'iransoft1390@gmail.com',
			'mobile'     => '09191958533',
			'created_at' => Carbon::now()->format( 'Y-m-d H:i:s' ),
			'updated_at' => Carbon::now()->format( 'Y-m-d H:i:s' ),
		] );
	}
}
