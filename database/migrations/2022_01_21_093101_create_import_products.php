<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_products', function (Blueprint $table) {
            $table->increments('ip_id');
            $table->integer('ip_admin_id');
            $table->integer('ip_product_id');
            $table->integer('ip_qty');
            $table->integer('ip_price');
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
        Schema::dropIfExists('import_products');
    }
}
