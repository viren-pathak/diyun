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
        Schema::create('debate_recent_views', function (Blueprint $table) {
            $table->id();
            // Use unsignedBigInteger for foreign keys
            $table->unsignedBigInteger('debate_id');
            $table->unsignedBigInteger('user_id');

            // Add foreign key constraints
            $table->foreign('debate_id')->references('id')->on('debates')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debate_recent_views');
    }
};
