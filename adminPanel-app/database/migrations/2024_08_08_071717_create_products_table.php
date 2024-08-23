<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("productTitle");
            $table->unsignedBigInteger("productCategoryId")->nullable();
            $table->unsignedBigInteger("barcode");
            $table->tinyInteger("productStatus");
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('stock');
            $table->string('imagePath1')->nullable();
            $table->string('imagePath2')->nullable();
            $table->string('imagePath3')->nullable();
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("productCategoryId")->references("id")->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
