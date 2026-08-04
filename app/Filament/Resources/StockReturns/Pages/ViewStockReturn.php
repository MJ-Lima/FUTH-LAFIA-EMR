<?php

namespace App\Filament\Resources\StockReturns\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\StockReturns\StockReturnResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockReturn extends ViewRecord
{
    protected static string $resource = StockReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
