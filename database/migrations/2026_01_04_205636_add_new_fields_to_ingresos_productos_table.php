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
        Schema::table('ingresos_productos', function (Blueprint $table) {
            $table->string('codigo_lote')->nullable()->after('nombre_producto');
            $table->string('unidad_medida')->default('Unidad')->after('codigo_lote');
            $table->integer('stock_minimo')->default(0)->after('cantidad_restante');
            $table->string('foto_factura')->nullable()->after('numero_factura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos_productos', function (Blueprint $table) {
            $table->dropColumn(['codigo_lote', 'unidad_medida', 'stock_minimo', 'foto_factura']);
        });
    }
};
