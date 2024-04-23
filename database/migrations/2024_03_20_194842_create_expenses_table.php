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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->references('id')->on('leases');
            $table->foreignId('invoice_id')->references('id')->on('invoices');
            $table->foreignId('account_id')->references('id')->on('accounts');
            $table->foreignId('supplier_id')->default(1)->references('id')->on('suppliers');
            // $table->string('title');
            $table->longText('description')->nullable();
            $table->unsignedFloat('ammount');
            $table->unsignedFloat('rate_exchange')->nullable();
            $table->unsignedFloat('ammount_exchange')->nullable();
            $table->string('type');
            $table->date('date');
            $table->integer('maintenance_budget')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
