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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('deposit_type', ['Efectivo', 'Transferencia'])->nullable()->after('notes');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('deposit_type');
            $table->string('deposit_folio')->nullable()->unique()->after('deposit_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['deposit_type', 'deposit_amount', 'deposit_folio']);
        });
    }
};
