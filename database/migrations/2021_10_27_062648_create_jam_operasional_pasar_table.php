<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamOperasionalPasarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jam_operasional_pasar', function (Blueprint $table) {
            $table->id('id_toko');
            $table->date('hari_operasional');
            $table->time('jam_operasional');
            $table->unsignedInteger('id_pengelola')->unique();

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
        Schema::dropIfExists('jam_operasional_pasar');
    }
}
