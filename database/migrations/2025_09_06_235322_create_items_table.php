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
        Schema::create('items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('title');
            $t->string('category');
            $t->string('conservation');        // e.g., "Novo", "Usado", etc.
            $t->text('description');
            $t->string('district')->nullable();
            $t->decimal('lat', 10, 7)->nullable();
            $t->decimal('lng', 10, 7)->nullable();
            $t->string('photo')->nullable();   // URL or app-local scheme
            $t->string('status')->default('Disponivel'); // align with app enum strings
            $t->timestamps();
            $t->softDeletes();
            $t->index(['owner_id', 'category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
