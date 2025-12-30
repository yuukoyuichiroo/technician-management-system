<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Transaksi;
use Filament\Tables\Actions\Action;

class RecentTransactionsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Transaksi Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaksi::query()
                    ->with(['items.jasa'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->formatStateUsing(fn($state) => '#' . str_pad($state, 5, '0', STR_PAD_LEFT))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_pelanggan')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jasa')
                    ->counts('items')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('status_pembayaran')
                    ->label('Pembayaran')
                    ->colors([
                        'success' => 'dibayar',
                        'danger' => 'belum_dibayar',
                    ])
                    ->icons([
                        'heroicon-m-check-circle' => 'dibayar',
                        'heroicon-m-x-circle' => 'belum_dibayar',
                    ])
                    ->formatStateUsing(fn(string $state): string => $state === 'dibayar' ? 'Lunas' : 'Belum Lunas'),

                Tables\Columns\BadgeColumn::make('status_pengerjaan')
                    ->label('Pengerjaan')
                    ->colors([
                        'success' => 'selesai',
                        'warning' => 'belum_selesai',
                    ])
                    ->icons([
                        'heroicon-m-check-badge' => 'selesai',
                        'heroicon-m-wrench-screwdriver' => 'belum_selesai',
                    ])
                    ->formatStateUsing(fn(string $state): string => $state === 'selesai' ? 'Selesai' : 'Proses'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn(Transaksi $record): string => "/admin/transaksis/{$record->id}")
                    ->color('info'),

                Tables\Actions\Action::make('print')
                    ->label('Cetak')
                    ->icon('heroicon-m-printer')
                    ->url(fn(Transaksi $record): string => route('nota.pdf', $record))
                    ->openUrlInNewTab()
                    ->color('success'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
