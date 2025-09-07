<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('exchange_id')->constrained('exchanges')->cascadeOnDelete();
            $t->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $t->text('message');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['exchange_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
