<?php

namespace App\Filament\Resources\DispensingPoints\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingPoints\DispensingPointResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDispensingPoint extends EditRecord
{
    protected static string $resource = DispensingPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
