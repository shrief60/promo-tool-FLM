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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['percentage', 'value']);
            $table->string('promo_code')->index();
            
            $table->string('title', 256)->nullable();
            $table->string('desc', 256)->nullable();

            $table->unsignedBigInteger('reference_value');
            $table->boolean('is_expired')->default(0);
            $table->enum('user_segment', ['all', 'specific']);
            $table->timestamp('expiry_date')->nullable();

            $table->unsignedBigInteger('max_usage_times');
            $table->unsignedBigInteger('max_usage_times_per_user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
