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
    Schema::create('ingresos_productos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
        $table->string('nombre_producto'); // Ej: "Gaseosa Cola 2L"
        $table->integer('cantidad_inicial'); // Ej: 255 unidades
        $table->integer('cantidad_restante'); // Ej: 255 unidades (al inicio)
        $table->decimal('costo_total', 10, 2); // Ej: 2500.50 Bs
        $table->date('fecha_ingreso');
        $table->string('numero_factura')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos_productos');
    }
};
