<?php

use Illuminate\Database\Seeder;
use database\seeds\ContactsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\User::class,10)->create();
		factory(App\News::class,10)->create();
		factory(App\NewsDetails::class,10)->create();
		//echo 'hi';
         //$this->call(UsersTableSeeder::class);
    }
}
