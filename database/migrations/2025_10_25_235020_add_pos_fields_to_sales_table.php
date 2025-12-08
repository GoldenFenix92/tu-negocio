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
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('user_id');
                $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
                $table->string('discount_coupon')->nullable()->after('discount_amount');
            }
            if (!Schema::hasColumn('sales', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['folio', 'subtotal', 'discount_amount', 'discount_coupon']);
            $table->dropSoftDeletes();
        });
    }
};
