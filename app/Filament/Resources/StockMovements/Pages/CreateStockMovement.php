<?php

namespace App\Filament\Resources\StockMovements\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\StockMovements\StockMovementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockMovement extends CreateRecord
{
    protected static string $resource = StockMovementResource::class;
}
