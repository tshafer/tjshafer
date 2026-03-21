<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('timezone', 64)->default('UTC');
            $table->string('status', 32)->default('pending');
            $table->timestamps();

            $table->index(['starts_at', 'ends_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
