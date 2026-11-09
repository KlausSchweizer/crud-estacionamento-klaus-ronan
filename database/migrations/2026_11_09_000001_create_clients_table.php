<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('client_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->unique(['client_id', 'vehicle_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_vehicle');
        Schema::dropIfExists('clients');
    }
};
