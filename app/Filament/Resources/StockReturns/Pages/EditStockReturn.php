<?php

namespace App\Filament\Resources\StockReturns\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\StockReturns\StockReturnResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStockReturn extends EditRecord
{
    protected static string $resource = StockReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
