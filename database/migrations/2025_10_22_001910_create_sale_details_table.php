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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->enum('item_type', ['service', 'product']); // Tipo de ítem vendido
            $table->integer('item_id'); // ID del ítem (service_id o product_id)

            $table->decimal('price', 8, 2); // Precio al momento de la venta
            $table->integer('quantity');

            $table->foreignId('stylist_id')->nullable()->constrained('users'); // Estilista/empleado que realizó el servicio

            $table->decimal('commission_paid', 8, 2)->default(0.00); // Monto de la comisión
            $table->timestamps();
            $table->softDeletes(); // Para el CRUD de ventas

            // Índice para optimizar búsquedas por item_type y item_id
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
