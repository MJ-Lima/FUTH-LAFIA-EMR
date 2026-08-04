<?php

namespace App\Filament\Resources\DispensingLogs\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingLogs\DispensingLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDispensingLogs extends ListRecords
{
    protected static string $resource = DispensingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
