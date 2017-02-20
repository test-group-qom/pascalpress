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
         factory(App\News::class, 20)->create()->each(function($n) {
    		$n->newsdetail()->save(factory(App\NewsDetail::class)->make());
 		 });   
     }
}
