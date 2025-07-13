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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->dateTime('occurred_at');
            $table->string('location');
            $table->string('status');
            $table->string('type');
            $table->boolean('is_anonymous')->default(false);
            $table->foreignId('specialist_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('uid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
