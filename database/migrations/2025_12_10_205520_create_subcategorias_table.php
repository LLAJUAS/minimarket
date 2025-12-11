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
    Schema::create('subcategorias', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
        
        // Aseguramos que el nombre de la subcategoría sea único dentro de una misma categoría
        $table->unique(['nombre', 'categoria_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategorias');
    }
};
