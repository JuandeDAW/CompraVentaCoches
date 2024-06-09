<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras_coches')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('valoraciones');
    }
};
