<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Transaksi;
use App\Models\Jasa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('lokasi')
                            ->label('Lokasi')
                            ->required()
                            ->rows(3)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Jasa')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('jasa_id')
                                    ->label('Jasa')
                                    ->options(Jasa::all()->pluck('nama_jasa', 'id'))
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $jasa = Jasa::find($state);
                                        if ($jasa) {
                                            $set('harga_satuan', $jasa->harga);
                                            $set('subtotal', $jasa->harga);
                                        }
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $hargaSatuan = $get('harga_satuan') ?? 0;
                                        $set('subtotal', $state * $hargaSatuan);
                                    })
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('harga_satuan')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Jasa')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                Jasa::find($state['jasa_id'])?->nama_jasa ?? 'Jasa Baru'
                            ),
                    ]),

                Forms\Components\Section::make('Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(2),

                        Forms\Components\Select::make('tipe_pembayaran')
                            ->label('Tipe Pembayaran')
                            ->options([
                                'cash' => 'Cash',
                                'non_cash' => 'Non Cash',
                            ])
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\Select::make('status_pembayaran')
                            ->label('Status Pembayaran')
                            ->options([
                                'dibayar' => 'Dibayar',
                                'belum_dibayar' => 'Belum Dibayar',
                            ])
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\Select::make('status_pengerjaan')
                            ->label('Status Pengerjaan')
                            ->options([
                                'selesai' => 'Selesai',
                                'belum_selesai' => 'Belum Selesai',
                            ])
                            ->default('belum_selesai')
                            ->required()
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->label('Total Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('tipe_pembayaran')
                    ->label('Tipe Pembayaran')
                    ->colors([
                        'success' => 'cash',
                        'warning' => 'non_cash',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst(str_replace('_', ' ', $state))),
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
                    ->options([
                        'dibayar' => 'Dibayar',
                        'belum_dibayar' => 'Belum Dibayar',
                    ]),
                Tables\Filters\SelectFilter::make('status_pengerjaan')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
            'view' => Pages\ViewTransaksi::route('/{record}'),
        ];
    }
}
