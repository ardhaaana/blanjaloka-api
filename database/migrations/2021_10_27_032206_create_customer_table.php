<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id('id_customer');
            $table->string('nama_customer');
            $table->integer('nomor_telepon');
            $table->string('alamat_customer')->nullable();
            $table->date('tanggal_lahir');
            $table->string('email_customer')->unique();
            $table->string('username')->unique();
            $table->string('password');

            $table->string('token')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
