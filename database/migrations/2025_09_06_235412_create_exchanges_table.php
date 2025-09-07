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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->dateTime('date');               // when exchange occurred/requested
            $table->text('notes')->nullable();
            $table->enum('type', ['TROCA','DOACAO'])->default('TROCA');
            $table->enum('status', ['PENDENTE','ACEITA','CONCLUIDA','CANCELADA'])->default('PENDENTE');
            $table->dateTime('status_datetime')->useCurrent();
            $table->unsignedInteger('avoided_items')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Idempotency: prevent exact duplicates
            $table->unique(['item_id','from_user_id','to_user_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
