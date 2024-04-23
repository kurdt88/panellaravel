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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property')->references('id')->on('properties');
            $table->foreignId('tenant')->references('id')->on('tenants');
            $table->integer('months_grace_period')->nullable();
            $table->foreignId('subproperty_id')->default(1)->references('id')->on('subproperties');
            $table->unsignedFloat('rent');
            $table->string('iva')->nullable();
            $table->string('iva_rate')->nullable();
            $table->string('type');
            $table->unsignedFloat('deposit')->default(0);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->longText('contract')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
