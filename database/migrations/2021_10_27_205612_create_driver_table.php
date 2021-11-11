<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->bigIncrements('id_driver');
            $table->string('nama_driver');
            $table->bigInteger('nomor_telepon');
            $table->string('alamat_driver');
            $table->date('tanggal_lahir');
            $table->bigInteger('nomor_ktp');
            $table->string('kendaraan');
            $table->string('foto_stnk');
            $table->unsignedBigInteger('id_pendaftaran')->nullable();

            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
}
