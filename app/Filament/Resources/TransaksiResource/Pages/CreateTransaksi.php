<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hitung total dari items
        $total = 0;
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += $item['subtotal'] ?? 0;
            }
        }
        $data['total_harga'] = $total;

        return $data;
    }

    protected function afterCreate(): void
    {
        // Recalculate total setelah items tersimpan
        $this->record->calculateTotal();
    }
}
