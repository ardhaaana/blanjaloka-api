<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjangProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang_produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_produk')->unsigned();
            $table->bigInteger('id_customer')->unsigned();
            $table->bigInteger('jumlah_produk');
            $table->bigInteger('subtotal');

            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_customer')->references('id_customer')->on('customer')
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
        Schema::dropIfExists('keranjang_produk');
    }
}