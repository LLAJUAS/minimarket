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
            $table->decimal('cantidad_inicial', 10, 2)->change();
            $table->decimal('cantidad_restante', 10, 2)->change();
            $table->decimal('stock_minimo', 10, 2)->change();
        });

        Schema::table('venta_productos', function (Blueprint $table) {
            $table->decimal('cantidad', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos_productos', function (Blueprint $table) {
            $table->integer('cantidad_inicial')->change();
            $table->integer('cantidad_restante')->change();
            $table->integer('stock_minimo')->change();
        });

        Schema::table('venta_productos', function (Blueprint $table) {
            $table->integer('cantidad')->change();
        });
    }
};
