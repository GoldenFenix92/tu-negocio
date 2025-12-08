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
        // La tabla historical_sales ya no existe, se eliminó
        // No necesitamos hacer nada aquí
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // La tabla historical_sales ya no existe, se eliminó
        // No necesitamos hacer nada aquí
    }
};
