<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_name');
            $table->string('style_name');
            $table->double('sam');
            $table->dateTime('delivery_date');
            $table->integer('qty');
            $table->integer('cqty')->default(0);
            $table->integer('eqty')->default(0);
            $table->integer('sqty')->default(0);
            $table->integer('wqty')->default(0);
            $table->integer('fqty')->default(0);
            $table->double('dhu')->default(0);
            $table->integer('p_pcs')->default(0);
            $table->integer('f_pcs')->default(0);
            $table->string('line')->nullable();
            $table->integer('factory_id');
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
        Schema::dropIfExists('orderns');
    }
}
