<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('watermark_enabled')->default(false)->after('is_active');
            $table->string('watermark_image')->nullable()->after('watermark_enabled');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['watermark_enabled', 'watermark_image']);
        });
    }
};