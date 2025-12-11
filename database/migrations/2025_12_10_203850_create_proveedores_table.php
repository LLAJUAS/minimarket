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
    Schema::create('proveedores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_empresa'); // Nombre de la empresa del proveedor
        $table->string('nombre_contacto')->nullable(); // Nombre de la persona de contacto
        $table->string('celular', 20)->nullable();
        $table->string('email')->unique()->nullable();
        $table->text('direccion')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
