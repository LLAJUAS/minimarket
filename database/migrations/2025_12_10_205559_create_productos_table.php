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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ingreso_producto_id')->constrained('ingresos_productos')->onDelete('cascade');
        $table->foreignId('subcategoria_id')->nullable()->constrained('subcategorias')->onDelete('set null');
        $table->string('codigo')->unique()->nullable(); // Código de barras
        $table->string('nombre'); // Nombre en la etiqueta
        $table->decimal('precio_venta_unitario', 10, 2); // Precio para el cliente
        $table->string('imagen')->nullable(); // Foto para la tienda
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
