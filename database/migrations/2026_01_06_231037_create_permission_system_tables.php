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
        // Table for permissions
        Schema::create('permissions', function (Blueprint $row) {
            $row->id();
            $row->string('nombre_permiso');
            $row->string('slug')->unique();
            $row->timestamps();
        });

        // Pivot table for roles and permissions
        Schema::create('permission_role', function (Blueprint $row) {
            $row->id();
            $row->foreignId('role_id')->constrained()->onDelete('cascade');
            $row->foreignId('permission_id')->constrained()->onDelete('cascade');
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};
