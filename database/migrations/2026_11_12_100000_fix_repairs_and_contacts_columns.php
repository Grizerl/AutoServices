<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * - repairs.price had no default, so the public booking form failed on strict MySQL.
     * - repairs.done is now a proper status with a default.
     * - contacts.phone was an INTEGER and could not store phone numbers like +380950660959.
     * - contacts.email is optional on the contact form.
     */
    public function up(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->default(0)->change();
            $table->string('done')->default('pending')->nullable(false)->change();
        });

        DB::table('repairs')->whereNull('done')->orWhere('done', '')->update(['done' => 'pending']);

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('phone', 32)->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });

        Schema::table('repairs', function (Blueprint $table) {
            $table->string('done')->nullable()->default(null)->change();
            $table->bigInteger('price')->default(null)->change();
        });
    }
};
