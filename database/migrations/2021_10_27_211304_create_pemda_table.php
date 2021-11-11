<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemdaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemda', function (Blueprint $table) {
            $table->bigIncrements('id_pemda');
            $table->string('nama_pemda');
            $table->string('alamat_pemda')->nullable();
            $table->string('nomor_telepon');
            $table->string('email')->unique();
            $table->string('nomor_ktp');
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('id_produk')->nullable();

            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemda');
    }
}
