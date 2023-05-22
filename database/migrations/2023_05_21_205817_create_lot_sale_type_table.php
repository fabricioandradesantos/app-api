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
        Schema::create('lot_sale_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained('lots');
            $table->foreignId('sale_type_id')->constrained('sale_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_sale_type');
    }
};
