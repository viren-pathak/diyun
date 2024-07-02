<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThanksTable extends Migration
{
    public function up()
    {
        Schema::create('thanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thanked_by_user_id')->constrained('users', 'id')->onDelete('cascade'); 
            $table->string('thanked_on');
            $table->unsignedBigInteger('thanked_activity_id');
            $table->foreignId('thanked_to_user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thanks');
    }
}
