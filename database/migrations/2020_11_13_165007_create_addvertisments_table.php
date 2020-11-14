<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddvertismentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addvertisments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('addvertisment_status');
            $table->unsignedBigInteger('addvertisment_translation_of')->nullable();
            $table->foreign('addvertisment_translation_of')->references('id')->on('addvertisments')->onUpdate('CASCADE')->onDelete('CASCADE');         
            $table->string('addvertisment_image');
            $table->string('addvertisment_description');
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
        Schema::dropIfExists('addvertisments');
    }
}
