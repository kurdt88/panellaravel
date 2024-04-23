<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->references('id')->on('leases');
            $table->foreignId('account_id')->references('id')->on('accounts');
            $table->foreignId('invoice_id')->references('id')->on('invoices');
            // $table->string('concept');
            $table->date('date');
            $table->unsignedFloat('ammount');
            $table->unsignedFloat('rate_exchange')->nullable();
            $table->unsignedFloat('ammount_exchange')->nullable();

            $table->string('type');
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
