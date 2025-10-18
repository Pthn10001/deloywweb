<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblDetailsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_details_id', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('product_id');
            $table->string('product_name');
            $table->float('product_price');
            $table->integer('product_sales_qty');

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
        Schema::dropIfExists('tbl_details_id');
    }
}
