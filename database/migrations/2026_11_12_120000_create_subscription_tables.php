<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('slug', 80)->unique();
            $table->string('description')->nullable();
            $table->string('icon', 40)->default('fa-star');              // Font Awesome class
            $table->unsignedInteger('price_monthly');                    // USD per month
            $table->unsignedInteger('price_yearly')->nullable();         // USD per year; null = 12 x monthly
            $table->text('features');                                    // included, one per line
            $table->text('excluded_features')->nullable();               // not included, one per line
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 12)->unique();                   // shown to the customer
            $table->foreignId('subscription_plan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('plan_name', 60);                             // snapshot: survives plan edits/deletion
            $table->string('billing_period', 10);                        // monthly | yearly
            $table->unsignedInteger('price');                            // USD for the chosen period, snapshot
            $table->string('name', 60);
            $table->string('phone', 32);
            $table->string('email')->nullable();
            $table->string('car', 120);
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');            // pending | active | cancelled | expired
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};
