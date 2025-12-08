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
            $table->integer('voucher_count')->default(0)->after('voucher_folio');
            $table->text('voucher_folios')->nullable()->after('voucher_count'); // JSON array of voucher folios
            $table->foreignId('cash_session_id')->nullable()->constrained('cash_sessions')->onDelete('set null')->after('voucher_folios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['cash_session_id']);
            $table->dropColumn(['voucher_count', 'voucher_folios', 'cash_session_id']);
        });
    }
};
