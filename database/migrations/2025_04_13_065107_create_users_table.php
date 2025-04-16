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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userRole', 20)->default('User');
            $table->string('email', 255)->unique();
            $table->string('username', 30)->unique();
            $table->string('password');
            $table->date('dob');
            $table->string('imgPath')->default('images/Default/_profile.png');
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
