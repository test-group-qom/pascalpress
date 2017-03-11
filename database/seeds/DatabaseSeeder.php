<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {		
         Model::unguard();
//    	 $this->call(UserTableSeeder::class);
//         $this->call(NewsTableSeeder::class);
         factory(App\User::class,3)->create();
         factory(App\News::class,10)->create();
         factory(App\NewsDetail::class,30)->create();
         Model::reguard();

          factory(App\Category::class, 3)
           ->create()
           ->each(function ($u) {
                $u->products()->save(factory(App\Product::class)->make());
            });

       factory(App\ProductDetail::class,30)->create();
       factory(App\ProductFile::class,30)->create();
    }
}
