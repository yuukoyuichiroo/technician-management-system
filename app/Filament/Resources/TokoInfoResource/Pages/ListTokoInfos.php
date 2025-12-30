<?php

namespace App\Filament\Resources\TokoInfoResource\Pages;

use App\Filament\Resources\TokoInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTokoInfos extends ListRecords
{
    protected static string $resource = TokoInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
