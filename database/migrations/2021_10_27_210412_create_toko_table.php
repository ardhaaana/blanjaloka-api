<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->bigIncrements('id_toko');
            $table->string('nama_toko');
            $table->string('alamat_toko');
            $table->unsignedBigInteger('id_pedagang')->nullable();

            $table->timestamps();

            $table->foreign('id_pedagang')->references('id_pedagang')->on('pedagang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko');
    }
}
