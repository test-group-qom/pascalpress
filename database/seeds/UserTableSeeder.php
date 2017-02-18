<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(App\User::class, 2)->create()->each(function($u) {
    		//$u->news()->save(factory(App\News::class)->make());
 		 });
    }
}
