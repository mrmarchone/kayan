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
        Schema::create(config('kayan.database_prefix') . '_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained(config('kayan.database_prefix') . '_sections')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('order')->default(0);
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('kayan.database_prefix') . '_posts');
    }
};
