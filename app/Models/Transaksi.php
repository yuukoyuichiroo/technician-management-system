<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'lokasi',
        'total_harga',
        'tipe_pembayaran',
        'status_pembayaran',
        'status_pengerjaan',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // Method untuk menghitung total otomatis
    public function calculateTotal()
    {
        $this->total_harga = $this->items()->sum('subtotal');
        $this->save();
    }
}
