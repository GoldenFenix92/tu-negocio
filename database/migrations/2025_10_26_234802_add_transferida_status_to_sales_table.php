<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE sales MODIFY COLUMN status ENUM('completada', 'pendiente', 'cancelada', 'transferida') DEFAULT 'completada'");
        DB::statement("ALTER TABLE sales MODIFY COLUMN payment_method ENUM('efectivo', 'tarjeta', 'transferencia', 'otro', 'mixto')");
        // La tabla historical_sales ya no existe, se eliminó
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE sales MODIFY COLUMN status ENUM('completada', 'pendiente', 'cancelada') DEFAULT 'completada'");
        // La tabla historical_sales ya no existe, se eliminó
    }
};
