<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpesialProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spesial_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->string('diskon');

            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')
            ->on('produk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spesial_produk');
    }
}
