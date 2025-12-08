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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('paternal_lastname')->after('first_name'); // Add paternal_lastname after first_name
            $table->string('maternal_lastname')->after('paternal_lastname'); // Add maternal_lastname after paternal_lastname
            $table->dropColumn('last_name'); // Remove the old last_name column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('paternal_lastname'); // Drop paternal_lastname
            $table->dropColumn('maternal_lastname'); // Drop maternal_lastname
            $table->string('last_name'); // Re-add the old last_name column
        });
    }
};
