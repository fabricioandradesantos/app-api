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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('zip_code')->nullable();
            $table->string('public_place');
            $table->string('number');
            $table->string('district');
            $table->foreignId('city_id')->constrained('cities');
            $table->decimal('width', 10, 2);
            $table->decimal('length', 10, 2);
            $table->decimal('area', 10,2);
            $table->decimal('price', 10,2)->nullable();
            $table->char('type', 1)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
