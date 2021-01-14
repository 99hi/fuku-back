<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_codes', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('closet_user_id');
            $table->string('share_code');
            $table->string('share_username');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('closet_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('share_code')->references('share_code')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_codes');
    }
}
