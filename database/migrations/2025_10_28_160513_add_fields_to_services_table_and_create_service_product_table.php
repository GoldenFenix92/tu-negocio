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
        Schema::table('services', function (Blueprint $table) {
            $table->string('service_id')->unique()->after('id');
            $table->string('image_path')->nullable()->after('description');
            $table->softDeletes();
        });

        Schema::create('service_product', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->primary(['service_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_product');

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('service_id');
            $table->dropColumn('image_path');
            $table->dropSoftDeletes();
        });
    }
};
