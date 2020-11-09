<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothesSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_seasons', function (Blueprint $table) {
            $table->unsignedInteger('clothes_id');
            $table->unsignedInteger('season_id');
            $table->primary(['clothes_id','season_id']);

            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clothes_seasons');
    }
}
