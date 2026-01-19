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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('auction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Ganti buyer_id jadi user_id
            
            // Data Harga
            $table->decimal('final_price', 15, 2); // Ganti total_price jadi final_price
            
            // Data Game (PENTING: Tambahan Baru)
            $table->string('game_username');
            $table->string('game_uid');
            
            // Bukti Bayar (PENTING: Tambahan Baru)
            $table->string('payment_proof'); 
            
            // Status (Pending = Menunggu Admin, Approved = Sukses, Rejected = Gagal)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps(); // created_at akan menjadi tanggal transaksi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};