<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolom jasa_id dan harga lama
            $table->dropForeign(['jasa_id']);
            $table->dropColumn(['jasa_id', 'harga']);

            // Tambah kolom total_harga
            $table->decimal('total_harga', 15, 2)->after('lokasi');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('jasa_id')->constrained('jasas')->onDelete('cascade');
            $table->decimal('harga', 15, 2);
            $table->dropColumn('total_harga');
        });
    }
};
