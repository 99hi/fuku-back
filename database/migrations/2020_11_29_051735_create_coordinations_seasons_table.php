<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinationsSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinations_seasons', function (Blueprint $table) {
            $table->unsignedInteger('coordinations_id');
            $table->unsignedInteger('seasons_id');
            $table->primary(['coordinations_id','seasons_id']);

            $table->foreign('coordinations_id')->references('id')->on('coordinations')->onDelete('cascade');
            $table->foreign('seasons_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinations_seasons');
    }
}
