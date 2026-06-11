<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_visibilities', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key')->unique(); // e.g. 'products', 'generator', 'chatbot', 'roas_calculator', 'shopee_fee_calculator'
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('group')->default('main'); // main, generator, workspace
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_sub_feature')->default(false); // true if this is a sub-feature within a menu
            $table->string('parent_menu')->nullable(); // parent menu key if sub-feature
            $table->string('route_name')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_visibilities');
    }
};