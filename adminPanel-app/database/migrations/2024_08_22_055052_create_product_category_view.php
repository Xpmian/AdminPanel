<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW product_category_view AS
        SELECT
            products.id AS product_id,
            products.productTitle,
            categories.categoryTitle,
            products.barcode,
            products.productStatus,
            products.price,
            products.stock,
            products.slug,
            products.deleted_at,
            products.created_at,
            products.updated_at,
            categories.id AS category_id
        FROM
            products
        LEFT JOIN
            categories
        ON
            products.productCategoryId = categories.id
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_view');
    }
};
