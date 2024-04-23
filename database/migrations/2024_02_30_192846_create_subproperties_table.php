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
        Schema::create('subproperties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->default(1)->references('id')->on('properties');
            $table->foreignId('landlord_id')->default(1)->references('id')->on('landlords');
            $table->string('title');
            $table->string('type');
            $table->unsignedFloat('rent')->default(0);
            // $table->unsignedFloat('deposit')->default(0);
            $table->string('address')->nullable();
            $table->longText('description')->nullable();
            $table->unique('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subproperties');
    }
};
