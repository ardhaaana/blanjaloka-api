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
            $table->bigIncrements('id_pesanan');
            $table->string('nama_customer');
            $table->bigInteger('nomor_telepon');
            $table->string('alamat_customer');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->unsignedBigInteger('id_pedagang')->nullable();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->string('pilihan_penawaran');
            $table->unsignedBigInteger('id_driver')->nullable();

            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_pedagang')->references('id_pedagang')->on('pedagang')->onDelete('cascade');
            $table->foreign('id_driver')->references('id_driver')->on('driver')->onDelete('cascade');
            
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
