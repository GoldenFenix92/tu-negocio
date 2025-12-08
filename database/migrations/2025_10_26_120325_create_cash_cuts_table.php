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
        Schema::create('cash_cuts', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('cut_date')->nullable();
            $table->integer('total_sales')->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('cash_amount', 10, 2)->default(0);
            $table->decimal('card_amount', 10, 2)->default(0);
            $table->decimal('transfer_amount', 10, 2)->default(0);
            $table->decimal('expected_cash', 10, 2)->default(0);
            $table->decimal('actual_cash', 10, 2)->default(0);
            $table->decimal('difference', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['open', 'closed', 'pending'])->default('open');
            $table->string('secret_code', 100)->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('folio');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_cuts');
    }
};
