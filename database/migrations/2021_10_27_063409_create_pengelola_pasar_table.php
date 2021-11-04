<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengelolaPasarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengelola_pasar', function (Blueprint $table) {
            $table->id('id_pengelola');
            $table->string('nama_pengelola');
            $table->string('alamat_pengelola')->nullable();
            $table->integer('nomor_telepon');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('id_role');

            $table->string('token_pp')->nullable();
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
        Schema::dropIfExists('pengelola_pasar');
    }
}
