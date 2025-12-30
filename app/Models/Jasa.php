<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jasa',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
