<?php

namespace App\Filament\Resources\Vitals\Pages;

use Filament\Schemas\Schema;


use App\Filament\Resources\Vitals\VitalsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVitals extends ViewRecord
{
    protected static string $resource = VitalsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
