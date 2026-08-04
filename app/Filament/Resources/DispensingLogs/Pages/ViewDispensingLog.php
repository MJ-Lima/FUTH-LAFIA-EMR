<?php

namespace App\Filament\Resources\DispensingLogs\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingLogs\DispensingLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDispensingLog extends ViewRecord
{
    protected static string $resource = DispensingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
