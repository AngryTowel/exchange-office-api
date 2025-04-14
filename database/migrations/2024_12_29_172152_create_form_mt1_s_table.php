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
        Schema::create('form_mt1_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained(table: 'organizations');
            $table->unsignedInteger('custom_id')->nullable(); // Custom auto-increment ID
//            $table->unique(['organization_id', 'custom_id']); // Make sure we have single custom id per organization.
            $table->foreignId('user_id')->constrained(table: 'users');
//            $table->string('exchange_office');
            $table->string('authorized_bank')->nullable();
            $table->dateTime('date_time')->useCurrent();
            $table->tinyInteger('type')->default(0)->comment('1 - Buying, 2 - Selling');
            $table->string('currency_type');
            $table->float('exchange_amount');
            $table->float('course');
            $table->float('value');
            $table->tinyInteger('residency')->comment('3 - Resident, 4 - Not Resident');
            $table->string('exchange_id')->nullable();
            $table->string('authorized_person');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_mt1_s');
    }
};
