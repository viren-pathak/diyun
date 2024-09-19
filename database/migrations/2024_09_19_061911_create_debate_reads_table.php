<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebateReadsTable extends Migration
{
    public function up()
    {
        Schema::create('debate_reads', function (Blueprint $table) {
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

    public function down()
    {
        Schema::dropIfExists('debate_reads');
    }
}
