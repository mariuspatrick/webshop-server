<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_to_carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopping_cart_id')->unsigned()->index();
            $table->bigInteger('product_id')->unsigned()->index();
            $table->string('unique_id')->unique();
            // $table->integer('product_quantity');
            $table->timestamps();
        });

        Schema::table('products_to_carts', function ($table) {
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts')->onDelete('cascade');
        });

        Schema::table('products_to_carts', function ($table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->foreign('product_quantity')->references('quantity')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_to_carts');
    }
}
