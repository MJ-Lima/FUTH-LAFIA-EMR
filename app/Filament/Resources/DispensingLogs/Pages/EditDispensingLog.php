<?php

namespace App\Filament\Resources\DispensingLogs\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingLogs\DispensingLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDispensingLog extends EditRecord
{
    protected static string $resource = DispensingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
