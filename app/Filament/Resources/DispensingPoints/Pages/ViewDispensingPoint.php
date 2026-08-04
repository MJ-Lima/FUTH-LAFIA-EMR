<?php

namespace App\Filament\Resources\DispensingPoints\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingPoints\DispensingPointResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDispensingPoint extends ViewRecord
{
    protected static string $resource = DispensingPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
