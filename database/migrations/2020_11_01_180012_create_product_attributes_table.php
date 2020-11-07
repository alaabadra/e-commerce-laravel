<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->default(0);
            $table->foreign('cart_id')->references('id')->on('carts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('product_attr_translation_of');
            $table->integer('product_attr_price');
            $table->string('product_attr_image')->nullable();
            $table->string('product_attr_quantity')->nullable();
            $table->tinyInteger('product_attr_status')->default(0);
            $table->tinyInteger('product_feature')->default(0);
            $table->tinyInteger('product_popular')->default(0);
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
        Schema::dropIfExists('product_attributes');
    }
}
