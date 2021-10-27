<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedagangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedagang', function (Blueprint $table) {
            $table->id('id_pedagang');
            $table->string('nama_pedagang');
            $table->integer('nomor_telepon');
            $table->string('alamat_pedagang');
            $table->date('tanggal_lahir');
            $table->integer('nomor_ktp');
            $table->string('foto_rekening');
            $table->integer('id_pendaftaran');

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
        Schema::dropIfExists('pedagang');
    }
}
