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
            $table->decimal('product_price', 9, 2)->nullable(false);
            $table->decimal('product_width', 9, 2)->nullable();
            $table->decimal('product_length', 9, 2)->nullable();
            $table->decimal('product_height', 9, 2)->nullable();
            $table->decimal('product_weight', 9, 2)->nullable();
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
