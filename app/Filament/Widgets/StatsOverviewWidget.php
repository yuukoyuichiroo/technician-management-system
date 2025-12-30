<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaksi;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // Total Pesanan
        $totalPesanan = Transaksi::count();

        // Belum Lunas
        $belumLunas = Transaksi::where('status_pembayaran', 'belum_dibayar')->count();

        // Sudah Lunas
        $sudahLunas = Transaksi::where('status_pembayaran', 'dibayar')->count();

        // Pengerjaan Selesai
        $selesai = Transaksi::where('status_pengerjaan', 'selesai')->count();

        // Belum Selesai
        $belumSelesai = Transaksi::where('status_pengerjaan', 'belum_selesai')->count();

        // Total Penghasilan (Sudah Lunas & Selesai)
        $totalPenghasilan = Transaksi::where('status_pembayaran', 'dibayar')
            ->where('status_pengerjaan', 'selesai')
            ->sum('total_harga');

        return [
            Stat::make('Total Pesanan', number_format($totalPesanan, 0, ',', '.'))
                ->description('Semua transaksi')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Belum Lunas', number_format($belumLunas, 0, ',', '.'))
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->chart([3, 5, 3, 7, 6, 4, 3, 2]),

            Stat::make('Sudah Lunas', number_format($sudahLunas, 0, ',', '.'))
                ->description('Pembayaran selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([2, 3, 4, 6, 7, 5, 6, 7]),

            Stat::make('Pengerjaan Selesai', number_format($selesai, 0, ',', '.'))
                ->description('Pekerjaan selesai')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info')
                ->chart([1, 3, 5, 6, 7, 5, 4, 6]),

            Stat::make('Belum Selesai', number_format($belumSelesai, 0, ',', '.'))
                ->description('Sedang dikerjakan')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('warning')
                ->chart([5, 4, 3, 5, 4, 3, 2, 1]),

            Stat::make('Total Penghasilan', 'Rp ' . number_format($totalPenghasilan, 0, ',', '.'))
                ->description('Lunas & Selesai')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([2, 4, 6, 8, 10, 12, 14, 16]),
        ];
    }
}
