<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name', 356)->nullable(false);
            $table->longText('product_description')->nullable();
            $table->integer('product_price')->nullable(false);
            $table->integer('product_width')->nullable();
            $table->integer('product_length')->nullable();
            $table->integer('product_height')->nullable();
            $table->integer('product_weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
