<?php

namespace App\Filament\Resources\RadiologyModalities\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyModalities\RadiologyModalityResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRadiologyModality extends ViewRecord
{
    protected static string $resource = RadiologyModalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
