<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Composite index untuk query utama
            $table->index(['user_id', 'is_archived', 'id']);
            $table->index('created_at');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_archived', 'id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status']);
        });
    }
};