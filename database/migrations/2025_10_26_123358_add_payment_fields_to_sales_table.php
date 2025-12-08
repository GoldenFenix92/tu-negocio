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
            $table->string('voucher_folio', 100)->nullable()->after('payment_method');
            $table->decimal('card_amount', 10, 2)->default(0)->after('voucher_folio');
            $table->decimal('cash_amount', 10, 2)->default(0)->after('card_amount');

            $table->index(['payment_method', 'voucher_folio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['payment_method', 'voucher_folio']);
            $table->dropColumn(['voucher_folio', 'card_amount', 'cash_amount']);
        });
    }
};
