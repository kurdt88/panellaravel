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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->default(1)->references('id')->on('buildings');
            $table->foreignId('landlord_id')->default(1)->references('id')->on('landlords');
            $table->string('title');
            $table->unsignedFloat('rent')->nullable();
            $table->string('location')->nullable();
            $table->longText('description')->nullable();
            $table->unique('title');


            //php artisan make:migration create_properties_table
            //php artisan migrate:refresh
            //Personal note: in order to interact with this table, we need a MODEL!
            //php artisan make:model Property

            //Then create a Controller to call the Views
            //php artisan make:controller PropertyController

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
