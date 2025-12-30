<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko',
        'nomor_telepon',
        'alamat',
    ];
}