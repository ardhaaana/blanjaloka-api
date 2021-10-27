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
            $table->id('id_pemda');
            $table->string('nama_pemda');
            $table->string('alamat_pemda')->nullable();
            $table->integer('nomor_telepon');
            $table->string('email')->unique();
            $table->integer('nomor_ktp');
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('kode_produk');

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
        Schema::dropIfExists('pemda');
    }
}
