<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinationsTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinations_tag', function (Blueprint $table) {
            $table->unsignedInteger('coordinations_id');
            $table->unsignedInteger('tag_id');
            $table->primary(['coordinations_id','tag_id']);

            $table->foreign('coordinations_id')->references('id')->on('coordinations')->onDelete('cascade');
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
        Schema::dropIfExists('coordinations_tag');
    }
}
