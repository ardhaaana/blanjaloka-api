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
            $table->bigIncrements('id_customer');
            $table->string('nama_customer');
            $table->bigInteger('nomor_telepon');
            $table->string('alamat_customer')->nullable();
            $table->date('tanggal_lahir');
            $table->string('email_customer')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->bigInteger('id_role')->unsigned()->nullable();
            $table->string('token')->nullable();
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
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
