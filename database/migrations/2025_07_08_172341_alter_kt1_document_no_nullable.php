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
            $table->string('document_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_1kt_s', function (Blueprint $table) {
            $table->string('document_no')->nullable(false)->change();
        });
    }
};
