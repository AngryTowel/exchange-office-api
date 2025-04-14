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
        Schema::create('form_1db_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained(table: 'organizations')->onDelete('cascade');
            $table->unsignedInteger('custom_id')->nullable(); // Custom auto-increment ID
            $table->unique(['organization_id', 'custom_id']); // Make sure we have single custom id per organization.
            $table->foreignId('currency_id')->constrained(table: 'currencies')->onDelete('cascade');
            $table->double('initial_value');
            $table->double('input');
            $table->double('output');
            $table->double('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_1db_s');
    }
};
