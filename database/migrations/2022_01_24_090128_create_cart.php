<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->string('cart_id');
            $table->integer('cart_user_id')->unsigned();
            $table->string('cart_product_name');
            $table->decimal('cart_product_price');
            $table->integer('cart_product_quantity');
            $table->string('cart_product_image');
            $table->string('cart_voucher_code')->nullable();
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
        Schema::dropIfExists('cart');
    }
}
