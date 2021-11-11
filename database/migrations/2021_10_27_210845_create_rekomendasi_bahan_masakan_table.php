<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekomendasiBahanMasakanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekomendasi_bahan_masakan', function (Blueprint $table) {
            $table->bigIncrements('id_rekomendasi');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->string('resep_masakan');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_pedagang')->nullable();

            $table->timestamps();
            
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
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
        Schema::dropIfExists('rekomendasi_bahan_masakan');
    }
}
