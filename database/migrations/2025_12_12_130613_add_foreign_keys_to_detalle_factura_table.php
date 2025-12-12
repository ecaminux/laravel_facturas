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
        Schema::table('detalle_factura', function (Blueprint $table) {
            $table->foreign(['factura_id'], 'detalle_factura_factura_id_fkey')->references(['id'])->on('facturas')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['producto_id'], 'detalle_factura_producto_id_fkey')->references(['id'])->on('productos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_factura', function (Blueprint $table) {
            $table->dropForeign('detalle_factura_factura_id_fkey');
            $table->dropForeign('detalle_factura_producto_id_fkey');
        });
    }
};
