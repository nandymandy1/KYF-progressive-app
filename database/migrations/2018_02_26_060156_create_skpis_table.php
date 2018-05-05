<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skpis', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('factory_id');
          $table->integer('income');
          $table->integer('sopr');
          $table->integer('kopr');
          $table->integer('prod');
          $table->integer('target');
          $table->integer('actual');
          $table->integer('outcome');
          $table->integer('sam');
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
        Schema::dropIfExists('skpis');
    }
}
