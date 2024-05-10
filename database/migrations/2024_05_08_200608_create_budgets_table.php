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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->references('id')->on('buildings');
            $table->string('month');
            $table->string('year');
            $table->float('maintenance_budget_mxn')->default(0);
            $table->float('maintenance_budget_usd')->default(0);
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->unique(array ('building_id', 'month', 'year'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
