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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secret_code',255);
            $table->string('colors',255);
            $table->enum('status',['en juego', 'finalizada con victoria','finalizada con derrota'])->default('en juego');
            $table->string('score')->default(0);
            $table->integer('round')->default(0);
            $table->string('user_code_1',255)->nullable();
            $table->string('check_code_1',255)->nullable();
            $table->string('user_code_2',255)->nullable();
            $table->string('check_code_2',255)->nullable();
            $table->string('user_code_3',255)->nullable();
            $table->string('check_code_3',255)->nullable();
            $table->string('user_code_4',255)->nullable();
            $table->string('check_code_4',255)->nullable();
            $table->string('user_code_5',255)->nullable();
            $table->string('check_code_5',255)->nullable();
            $table->string('user_code_6',255)->nullable();
            $table->string('check_code_6',255)->nullable();
            $table->string('user_code_7',255)->nullable();
            $table->string('check_code_7',255)->nullable();
            $table->string('user_code_8',255)->nullable();
            $table->string('check_code_8',255)->nullable();
            $table->string('user_code_9',255)->nullable();
            $table->string('check_code_9',255)->nullable();
            $table->string('user_code_10',255)->nullable();
            $table->string('check_code_10',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
