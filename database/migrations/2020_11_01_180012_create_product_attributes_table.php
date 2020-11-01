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
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('product_attr_name')->nullable();
            $table->string('product_attr_language');
            $table->integer('product_attr_translation_of');
            $table->integer('product_attr_price');
            $table->string('product_attr_currency');
            $table->string('product_attr_image')->nullable();
            $table->string('product_attr_quantity')->nullable();
            $table->string('product_attr_url')->nullable();
            $table->string('product_attr_type')->nullable();
            $table->tinyInteger('product_attr_status')->default(0);
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
