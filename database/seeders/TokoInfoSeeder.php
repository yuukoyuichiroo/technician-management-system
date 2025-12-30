<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TokoInfo;

class TokoInfoSeeder extends Seeder
{
    public function run(): void
    {
        TokoInfo::create([
            'nama_toko' => 'Jasa Teknisi Komputer Pro',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123, Jakarta Pusat',
        ]);
    }
}
