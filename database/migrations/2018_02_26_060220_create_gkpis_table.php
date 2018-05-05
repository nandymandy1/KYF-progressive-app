<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gkpis', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('factory_id');
          $table->double('payrole');
          $table->integer('ppeople');
          $table->integer('cpeople');
          $table->double('ocut');
          $table->double('osew');
          $table->double('ofin');
          $table->integer('abs');
          $table->integer('twf');
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
        Schema::dropIfExists('gkpis');
    }
}
