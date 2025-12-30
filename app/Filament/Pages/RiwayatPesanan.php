<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Transaksi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\Action;
use Filament\Forms;

class RiwayatPesanan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.riwayat-pesanan';

    protected static ?string $navigationLabel = 'Riwayat Pesanan';

    protected static ?int $navigationSort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaksi::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pesanan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Jasa')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Pembayaran')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->colors([
                        'success' => 'dibayar',
                        'danger' => 'belum_dibayar',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\BadgeColumn::make('status_pengerjaan')
                    ->label('Status Pengerjaan')
                    ->colors([
                        'success' => 'selesai',
                        'warning' => 'belum_selesai',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'dibayar' => 'Dibayar',
                        'belum_dibayar' => 'Belum Dibayar',
                    ]),
                Tables\Filters\SelectFilter::make('status_pengerjaan')
                    ->label('Status Pengerjaan')
                    ->options([
                        'selesai' => 'Selesai',
                        'belum_selesai' => 'Belum Selesai',
                    ]),
            ])
            ->actions([
                Action::make('cetak_nota')
                    ->label('Cetak Nota')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn(Transaksi $record): string => route('nota.pdf', $record))
                    ->openUrlInNewTab(),
                Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Pesanan')
                    ->modalWidth('5xl')
                    ->modalContent(fn(Transaksi $record): \Illuminate\View\View => view(
                        'filament.pages.detail-pesanan',
                        ['record' => $record]
                    ))
                    ->modalFooterActions([
                        Action::make('cetak')
                            ->label('Cetak Nota')
                            ->icon('heroicon-o-printer')
                            ->color('success')
                            ->url(fn(Transaksi $record): string => route('nota.pdf', $record))
                            ->openUrlInNewTab(),
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
