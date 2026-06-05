// database/migrations/2025_05_29_000001_create_api_keys_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // 'gemini', 'pollinations'
            $table->string('key')->unique();
            $table->string('status')->default('active'); // active, limited, disabled
            $table->timestamp('last_checked_at')->nullable();
            $table->integer('fail_count')->default(0);
            $table->text('notes')->nullable();
            $table->integer('priority')->default(0); // higher = lebih diprioritaskan
            $table->timestamps();
            
            $table->index(['provider', 'status', 'priority']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};