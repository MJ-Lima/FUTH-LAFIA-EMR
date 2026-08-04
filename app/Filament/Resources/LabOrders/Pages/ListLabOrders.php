<?php

namespace App\Filament\Resources\LabOrders\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\LabOrders\LabOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLabOrders extends ListRecords
{
    protected static string $resource = LabOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
