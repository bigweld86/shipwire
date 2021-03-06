<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('order_status');
            $table->decimal('order_total', 9, 2)->nullable(true);
            $table->string('order_customer_first_name')->nullable(true);
            $table->string('order_customer_last_name')->nullable(true);
            $table->string('order_address')->nullable(true);
            $table->string('order_city')->nullable(true);
            $table->string('order_state')->nullable(true);
            $table->string('order_zip')->nullable(true);
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
        Schema::dropIfExists('orders');
    }
}
