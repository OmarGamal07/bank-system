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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('clients')->cascadeOnUpdate()->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('clients')->cascadeOnUpdate()->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->cascadeOnUpdate()->onDelete('cascade');
            $table->foreignId('bank_id')->constrained()->cascadeOnUpdate()->onDelete('cascade');
            $table->decimal('mount',10,2)->default(0);
            $table->date('dateTransfer')->nullable();
            $table->string('numberAccount');
            $table->string('numberOperation')->unique();
            $table->enum('status',['accept','reject'])->default('accept');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
