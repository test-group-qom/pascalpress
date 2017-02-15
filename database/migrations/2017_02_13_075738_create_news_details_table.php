<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang')-> nullable(false);
            $table->string('title')->unique()-> nullable(false);
            $table->string('summery');
            $table->text('text');
            $table->string('tags');
            $table->timestamps();
        });

        Schema::table('news_details', function ($table) {
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_details');
    }
}
