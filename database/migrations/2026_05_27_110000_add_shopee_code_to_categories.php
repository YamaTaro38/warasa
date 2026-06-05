<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('shopee_code')->nullable()->after('slug');
        });
    }

    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('shopee_code');
        });
    }
};