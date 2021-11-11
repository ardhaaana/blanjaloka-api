<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTeleponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_telepon', function (Blueprint $table) {
            $table->bigIncrements('id_chat');
            $table->unsignedBigInteger('id_pedagang')->nullable();
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_driver')->nullable();
            $table->string('pesan');

            $table->timestamps();

            $table->foreign('id_pedagang')->references('id_pedagang')->on('pedagang')->onDelete('cascade');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
            $table->foreign('id_driver')->references('id_driver')->on('driver')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_telepon');
    }
}
