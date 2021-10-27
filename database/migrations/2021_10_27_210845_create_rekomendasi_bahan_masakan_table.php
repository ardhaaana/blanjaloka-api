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
            $table->id('id_rekomendasi');
            $table->integer('kode_produk');
            $table->string('resep_masakan');
            $table->integer('id_customer');
            $table->integer('id_pedagang');

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
        Schema::dropIfExists('rekomendasi_bahan_masakan');
    }
}
