<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_coches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id'); // Vendedor
            $table->unsignedBigInteger('buyer_id'); // Comprador
            $table->unsignedBigInteger('car_id'); // Coche
            $table->foreign('seller_id')->references('user_id')->on('cars')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
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
        Schema::dropIfExists('ventas_coches');
    }
};
