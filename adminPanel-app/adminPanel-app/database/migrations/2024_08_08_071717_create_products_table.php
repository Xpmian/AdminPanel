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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("productTitle");
            $table->unsignedBigInteger("productCategoryId");
            $table->unsignedBigInteger("barcode");
            $table->tinyInteger("productStatus");
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
