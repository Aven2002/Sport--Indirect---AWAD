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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->contrained()->onDelete('cascade');
            $table->string('name',50);
            $table->string('phoneNo',20);
            $table->string('addressLine');
            $table->string('city',50);
            $table->string('state',50);
            $table->integer('postcode');
            $table->boolean('isDefault')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
