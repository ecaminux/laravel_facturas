<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->text('nombre');
            $table->text('ruc')->unique('clientes_ruc_key');
            $table->text('direccion')->nullable();
            $table->text('ciudad')->nullable();
            $table->text('telefono')->nullable();
            $table->text('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
