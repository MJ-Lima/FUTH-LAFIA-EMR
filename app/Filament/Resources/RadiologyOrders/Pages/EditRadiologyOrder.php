<?php

namespace App\Filament\Resources\RadiologyOrders\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyOrders\RadiologyOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRadiologyOrder extends EditRecord
{
    protected static string $resource = RadiologyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
