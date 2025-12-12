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
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user_id');
            $table->increments('numero')->unique('facturas_numero_key');
            $table->bigInteger('cliente_id');
            //$table->foreignId('cliente_id')->constrained('clientes');
            $table->date('fecha_emision')->default('CURRENT_DATE');
            $table->decimal('subtotal', 10);
            $table->decimal('iva', 10);
            $table->decimal('total', 10);
            $table->text('estado')->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
