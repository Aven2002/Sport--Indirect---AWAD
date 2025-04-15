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
        Schema::create('productDetails', function(Blueprint $table){
            $table->foreignid('product_id')->constrained()->onDelete('cascade')->primary();
            $table->text('description');
            $table->integer('stock');
            $table->string('imgPath')->default('images/default/_product.png');
            $table->decimal('price',10,2)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productDetails');
    }
};
