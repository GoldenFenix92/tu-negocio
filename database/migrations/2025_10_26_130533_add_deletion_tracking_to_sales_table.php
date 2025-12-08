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
            $table->string('deleted_by_type')->nullable()->after('deleted_at');
            $table->unsignedBigInteger('deleted_by_id')->nullable()->after('deleted_by_type');
            $table->text('deletion_reason')->nullable()->after('deleted_by_id');

            $table->index(['deleted_by_type', 'deleted_by_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['deleted_by_type', 'deleted_by_id']);
            $table->dropColumn(['deleted_by_type', 'deleted_by_id', 'deletion_reason']);
        });
    }
};
