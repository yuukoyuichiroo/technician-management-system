<?php

namespace App\Filament\Resources\TokoInfoResource\Pages;

use App\Filament\Resources\TokoInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTokoInfo extends EditRecord
{
    protected static string $resource = TokoInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
