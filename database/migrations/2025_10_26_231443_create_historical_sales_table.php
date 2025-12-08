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
        Schema::create('historical_sales', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('discount_coupon')->nullable();
            $table->enum('payment_method', ['efectivo', 'tarjeta', 'transferencia', 'otro', 'mixto']);
            $table->enum('status', ['completada', 'pendiente', 'cancelada', 'transferida'])->default('completada');
            $table->date('sale_date'); // Date of the sale
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_sales');
    }
};
