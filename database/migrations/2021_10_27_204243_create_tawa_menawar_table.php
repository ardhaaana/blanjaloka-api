<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTawaMenawarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tawa_menawar', function (Blueprint $table) {
            $table->id('id_tawar');
            $table->integer('id_pedagang');
            $table->integer('id_customer');
            $table->integer('harga_nego');

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
        Schema::dropIfExists('tawa_menawar');
    }
}
