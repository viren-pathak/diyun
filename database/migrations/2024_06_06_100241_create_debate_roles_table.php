<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('debate_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('root_id')->constrained('debates')->onDelete('cascade');
            $table->enum('role', ['owner', 'admin', 'editor', 'writer', 'suggester', 'viewer'])->default('suggester')->change();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debate_roles');
    }
}
