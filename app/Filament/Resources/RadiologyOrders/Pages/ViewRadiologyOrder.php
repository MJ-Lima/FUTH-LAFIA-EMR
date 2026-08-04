<?php

namespace App\Filament\Resources\RadiologyOrders\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyOrders\RadiologyOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRadiologyOrder extends ViewRecord
{
    protected static string $resource = RadiologyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
