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
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
                $table->string('guest_name')->nullable();
                $table->dateTime('appointment_datetime');
                $table->enum('status', ['Pendiente', 'Anticipo', 'Pagado', 'Cancelado'])->default('Pendiente');
                $table->text('comments')->nullable();
                $table->enum('deposit_type', ['Efectivo', 'Transferencia'])->nullable();
                $table->decimal('deposit_amount', 10, 2)->nullable();
                $table->string('deposit_folio')->nullable()->unique();
                $table->decimal('total', 10, 2)->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
