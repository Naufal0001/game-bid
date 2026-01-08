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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->decimal('starting_price', 15, 2);
            $table->decimal('current_price', 15, 2)->nullable();
            $table->decimal('buyout_price', 15, 2)->nullable();
            $table->decimal('min_increment', 15, 2)->default(1000);
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_buyout')->default(false);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
