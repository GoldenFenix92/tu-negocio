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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // EBC-VNTA-001, EBC-VNTA-002, etc.
            $table->foreignId('client_id')->nullable()->constrained('clients'); // Cliente (opcional)
            $table->foreignId('user_id')->constrained('users'); // Cajero o quien registra la venta
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('discount_coupon')->nullable(); // Cupón de descuento aplicado
            $table->enum('payment_method', ['efectivo', 'tarjeta', 'transferencia', 'otro', 'mixto']);
            $table->enum('status', ['completada', 'pendiente', 'cancelada', 'transferida'])->default('completada');
            $table->timestamps();
            $table->softDeletes(); // Para el CRUD de ventas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
