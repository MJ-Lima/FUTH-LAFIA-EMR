<?php

namespace App\Filament\Resources\RadiologyModalities\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyModalities\RadiologyModalityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRadiologyModality extends EditRecord
{
    protected static string $resource = RadiologyModalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
