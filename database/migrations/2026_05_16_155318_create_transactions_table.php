<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transactions');
        Schema::enableForeignKeyConstraints();

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_sewa'); // Sesuai dengan Model Anda
            $table->date('tanggal_kembali');
            $table->decimal('total_harga', 15, 2)->nullable();
            
            // Tambahkan kolom bukti pembayaran
            $table->string('bukti_pembayaran')->nullable(); 
            
            // Sesuaikan enum status dengan logika tolak/setujui
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};