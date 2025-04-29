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
        Schema::create('form_1kt_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained(table: 'organizations')->onDelete('cascade');
            $table->unsignedInteger('custom_id')->nullable(); // Custom auto-increment ID
//            $table->unique(['organization_id', 'custom_id']); // Make sure we have single custom id per organization.
            $table->foreignId('user_id')->constrained(table: 'users');
//            $table->string('exchange_office');
//            $table->string('exchange_office_id');
//            $table->string('exchange_office_address');
            $table->dateTime('date_time')->useCurrent();
            $table->string('document_no');
            $table->string('description');
            $table->string('currency_type');
            $table->float('exchange_amount_input')->default(0);
            $table->float('exchange_amount_output')->default(0);
            $table->float('rate');
            $table->string('funds_type')->nullable();
            $table->float('value_input')->default(0);
            $table->float('value_output')->default(0);
            $table->string('authorized_bank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_1kt_s');
    }
};
