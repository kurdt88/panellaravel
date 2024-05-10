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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->references('id')->on('leases');
            $table->integer('sequence');
            // property_id sirve para crear facturas que NO estan asociadas a un contrato, pero SI a una propiedad
            $table->integer('property_id')->nullable();
            $table->integer('subproperty_id')->nullable();
            $table->float('ammount');
            $table->string('type');
            $table->string('category');
            $table->string('concept');
            $table->string('subconcept');
            $table->string('iva');
            $table->string('iva_rate');
            $table->float('iva_ammount');
            $table->date('start_date');
            $table->date('due_date');
            $table->longText('comment');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
