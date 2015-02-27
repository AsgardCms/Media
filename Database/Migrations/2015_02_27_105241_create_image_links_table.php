<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageLinksTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('media__imageable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id');
            $table->integer('imageable_id');
            $table->integer('imageable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('media__imageable');
    }
}
