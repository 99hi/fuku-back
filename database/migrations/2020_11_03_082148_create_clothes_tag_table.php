<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothesTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_tag', function (Blueprint $table) {
            $table->unsignedInteger('clothes_id');
            $table->unsignedInteger('tag_id');
            $table->primary(['clothes_id','tag_id']);

            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clothes_tag');
    }
}
