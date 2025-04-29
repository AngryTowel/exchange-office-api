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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('country');
            $table->string('currency')->nullable()->default(null);
            $table->float('buying_rate');
            $table->float('selling_rate');
            $table->boolean('isDefault')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->foreignId('organization_id')->constrained(table: 'organizations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
