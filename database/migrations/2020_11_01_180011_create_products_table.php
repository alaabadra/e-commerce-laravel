<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('product_name')->nullable();
            $table->longText('product_image')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('product_description')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_crop')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_quantity')->nullable();
            $table->string('product_status');
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
        Schema::dropIfExists('products');
    }
}
