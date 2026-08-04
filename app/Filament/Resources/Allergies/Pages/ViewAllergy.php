<?php

namespace App\Filament\Resources\Allergies\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Allergies\AllergyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAllergy extends ViewRecord
{
    protected static string $resource = AllergyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
