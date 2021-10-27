<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('nama_customer');
            $table->integer('nomor_telepon');
            $table->string('alamat_customer');
            $table->integer('kode_produk');
            $table->integer('id_pedagang');
            $table->integer('kode_transaksi');
            $table->string('pilihan_penawaran');
            $table->integer('id_driver');

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
        Schema::dropIfExists('pesanan');
    }
}
