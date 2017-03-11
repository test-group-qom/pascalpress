<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->timestamps();

            
        });
         Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->timestamps();

           $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
        });
          Schema::create('product_details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('config');
            $table->text('descriptions');
            $table->text('spesefication');
            $table->string('language');
            $table->timestamps();

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
        });
           Schema::create('product_files', function (Blueprint $table) {
            $table->increments('id');
             $table->char('type',1)-> nullable(false);
            $table->string('path');
            $table->timestamps();

           $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_details');
        Schema::dropIfExists('product_files');
    }
}
