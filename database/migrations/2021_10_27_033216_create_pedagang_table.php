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
            $table->bigIncrements('id_pedagang');
            $table->string('nama_pedagang');
            $table->bigInteger('nomor_telepon');
            $table->string('alamat_pedagang');
            $table->date('tanggal_lahir');
            $table->string('foto_rekening');
            $table->bigInteger('nomor_ktp');
            $table->string('nama_toko');
            $table->string('alamat_toko');
            $table->unsignedBigInteger('id_pendaftaran')->nullable();
            $table->timestamps();


            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran')
            ->onUpdate('cascade')->onDelete('cascade');
                  
                  
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
