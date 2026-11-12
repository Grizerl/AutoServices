<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 60);
            $table->string('model', 80);
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('mileage')->default(0);          // km
            $table->unsignedInteger('price');                        // USD
            $table->unsignedInteger('old_price')->nullable();        // shown crossed out when higher than price
            $table->string('fuel', 20)->default('petrol');
            $table->string('transmission', 20)->default('manual');
            $table->string('color', 40)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status', 20)->default('available');      // available | reserved | sold
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['status', 'brand']);
        });

        Schema::create('car_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('phone', 32);
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('new');           // new | contacted | closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_inquiries');
        Schema::dropIfExists('cars');
    }
};
