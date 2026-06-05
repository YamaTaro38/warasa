<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('product_ids')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('format')->default('shopee');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_histories');
    }
};