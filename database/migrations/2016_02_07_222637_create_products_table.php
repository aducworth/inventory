<?php

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
            $table->increments('id');
            $table->text('name');
            $table->text('notes');
            $table->integer('store_id');
            $table->integer('location_id');
            $table->integer('source_id');
            $table->decimal('purchase_price',10,2)->default(0);
            $table->decimal('sale_price',10,2)->default(0);
            $table->decimal('shipping_paid',10,2)->default(0);
            $table->decimal('actual_shipping',10,2)->default(0);
            $table->decimal('seller_fee',10,2)->default(0);
            $table->decimal('shipping_fee',10,2)->default(0);
            $table->decimal('transaction_fee',10,2)->default(0);
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
        Schema::drop('products');
    }
}
