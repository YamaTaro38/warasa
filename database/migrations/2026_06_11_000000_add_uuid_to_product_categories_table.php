<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('uuid', 36)->nullable()->after('id');
        });

        // Generate UUIDs for existing records
        foreach (\DB::table('product_categories')->get() as $category) {
            \DB::table('product_categories')
                ->where('id', $category->id)
                ->update(['uuid' => Str::uuid()->toString()]);
        }

        // Now make it unique and not null
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('uuid', 36)->unique()->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};