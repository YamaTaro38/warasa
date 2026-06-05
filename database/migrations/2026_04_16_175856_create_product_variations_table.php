// database/migrations/2024_01_01_000008_create_product_variations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->json('attributes')->nullable(); // {"size": "XL", "color": "Red"}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};