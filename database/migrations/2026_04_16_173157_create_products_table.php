<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('uuid')->unique()->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('weight')->default(250);
            $table->string('dimension')->nullable();
            $table->json('shipping_options')->nullable();
            $table->json('variations')->nullable();
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('ai_generated_title')->nullable();
            $table->text('ai_generated_description')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_archived')->default(false);
            $table->boolean('watermark_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};