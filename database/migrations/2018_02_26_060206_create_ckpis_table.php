<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckpis', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('factory_id');
          $table->integer('cqty');
          $table->integer('tpeople');
          $table->integer('psew');
          $table->integer('pemb');
          $table->integer('pcut');
          $table->integer('fout');
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
        Schema::dropIfExists('ckpis');
    }
}
