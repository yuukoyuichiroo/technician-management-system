<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class MonthlyStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunBulanLalu = Carbon::now()->subMonth()->year;

        // Transaksi Bulan Ini
        $transaksiBulanIni = Transaksi::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        // Transaksi Bulan Lalu
        $transaksiBulanLalu = Transaksi::whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunBulanLalu)
            ->count();

        // Penghasilan Bulan Ini
        $penghasilanBulanIni = Transaksi::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->where('status_pembayaran', 'dibayar')
            ->where('status_pengerjaan', 'selesai')
            ->sum('total_harga');

        // Penghasilan Bulan Lalu
        $penghasilanBulanLalu = Transaksi::whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunBulanLalu)
            ->where('status_pembayaran', 'dibayar')
            ->where('status_pengerjaan', 'selesai')
            ->sum('total_harga');

        // Pending Bulan Ini (belum lunas atau belum selesai)
        $pendingBulanIni = Transaksi::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->where(function ($query) {
                $query->where('status_pembayaran', 'belum_dibayar')
                    ->orWhere('status_pengerjaan', 'belum_selesai');
            })
            ->sum('total_harga');

        // Hitung persentase perubahan
        $perubahanTransaksi = $transaksiBulanLalu > 0
            ? (($transaksiBulanIni - $transaksiBulanLalu) / $transaksiBulanLalu) * 100
            : 0;

        $perubahanPenghasilan = $penghasilanBulanLalu > 0
            ? (($penghasilanBulanIni - $penghasilanBulanLalu) / $penghasilanBulanLalu) * 100
            : 0;

        return [
            Stat::make('Transaksi Bulan Ini', number_format($transaksiBulanIni, 0, ',', '.'))
                ->description(
                    $perubahanTransaksi >= 0
                        ? number_format(abs($perubahanTransaksi), 1) . '% lebih tinggi'
                        : number_format(abs($perubahanTransaksi), 1) . '% lebih rendah'
                )
                ->descriptionIcon($perubahanTransaksi >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($perubahanTransaksi >= 0 ? 'success' : 'danger')
                ->chart(array_fill(0, 7, rand(1, 10))),

            Stat::make('Penghasilan Bulan Ini', 'Rp ' . number_format($penghasilanBulanIni, 0, ',', '.'))
                ->description(
                    $perubahanPenghasilan >= 0
                        ? number_format(abs($perubahanPenghasilan), 1) . '% lebih tinggi'
                        : number_format(abs($perubahanPenghasilan), 1) . '% lebih rendah'
                )
                ->descriptionIcon($perubahanPenghasilan >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('success')
                ->chart(array_fill(0, 7, rand(5, 15))),

            Stat::make('Potensi Penghasilan', 'Rp ' . number_format($pendingBulanIni, 0, ',', '.'))
                ->description('Menunggu penyelesaian bulan ini')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart(array_fill(0, 7, rand(3, 12))),
        ];
    }
}
