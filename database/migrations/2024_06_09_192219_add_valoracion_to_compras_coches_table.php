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
        Schema::table('compras_coches', function (Blueprint $table) {
            $table->boolean('valoracion_dejada')->default(false)->after('buyer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compras_coches', function (Blueprint $table) {
            $table->dropColumn('valoracion_dejada');
        });
    }
};
