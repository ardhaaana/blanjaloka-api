<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_transaksi')->unsigned()->nullable();
            $table->string('jenis_pembayaran');
            $table->integer('pajak');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_pedagang')->nullable();
            $table->integer('total_pembayaran');

            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
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
        Schema::dropIfExists('transaksi');
    }
}
