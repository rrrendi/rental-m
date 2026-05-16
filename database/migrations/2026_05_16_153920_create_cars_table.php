<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi')->unique();
            $table->string('merk');
            $table->string('jenis');
            $table->decimal('harga', 15, 2);
            $table->string('foto')->nullable();
            // Tambahkan baris ini untuk status ketersediaan mobil:
            $table->enum('status_mobil', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};