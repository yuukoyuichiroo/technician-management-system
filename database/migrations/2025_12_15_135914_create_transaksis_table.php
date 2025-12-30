<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->text('lokasi');
            $table->foreignId('jasa_id')->constrained('jasas')->onDelete('cascade');
            $table->decimal('harga', 15, 2);
            $table->enum('tipe_pembayaran', ['cash', 'non_cash']);
            $table->enum('status_pembayaran', ['dibayar', 'belum_dibayar']);
            $table->enum('status_pengerjaan', ['selesai', 'belum_selesai'])->default('belum_selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
