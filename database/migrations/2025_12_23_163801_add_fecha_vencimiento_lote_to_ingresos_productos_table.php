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
        $table->date('fecha_vencimiento_lote')
              ->nullable()
              ->after('fecha_ingreso');
    });
}

public function down(): void
{
    Schema::table('ingresos_productos', function (Blueprint $table) {
        $table->dropColumn('fecha_vencimiento_lote');
    });
}

};
