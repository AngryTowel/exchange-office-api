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
        Schema::table('form_1kt_s', function (Blueprint $table) {
            $table->foreignId('form_mt1_id')->nullable()->constrained(table: 'form_mt1_s');
            $table->foreignId('currency_id')->nullable()->constrained(table: 'currencies');
        });
        Schema::table('form_mt1_s', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->constrained(table: 'currencies');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_1kt_s', function (Blueprint $table) {
            $table->removeColumn('form_mt1_id');
            $table->removeColumn('currency_id');
        });
    }
};
