<?php

namespace App\Filament\Resources\Purchases\Pages;
use Filament\Schemas\Schema;

use App\Filament\Resources\Purchases\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;
}
