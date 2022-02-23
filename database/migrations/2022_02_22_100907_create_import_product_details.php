<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProductDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_product_details', function (Blueprint $table) {
            $table->increments('ipd_id');
            $table->integer('ipd_import_product_id');
            $table->integer('ipd_product_id');
            $table->integer('ipd_quantity');
            $table->decimal('ipd_price', 12, 2);
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
        Schema::dropIfExists('import_product_details');
    }
}
