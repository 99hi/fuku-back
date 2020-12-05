<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothesCoordinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_coordinations', function (Blueprint $table) {
            $table->unsignedInteger('coordinations_id');
            $table->unsignedInteger('clothes_id');
            $table->integer('x');
            $table->integer('y');
            $table->integer('width');
            $table->integer('height');

            $table->foreign('coordinations_id')->references('id')->on('coordinations')->onDelete('cascade');
            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clothes_coordinations');
    }
}
