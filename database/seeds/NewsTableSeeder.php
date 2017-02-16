<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		echo 'News seeding\n';
         factory(App\News::class, 20)->create()->each(function($u) {
    		$u->newsdetails()->save(factory(App\NewsDetails::class)->make());
 		 });   
     }
}
