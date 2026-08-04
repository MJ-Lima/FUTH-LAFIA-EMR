<?php

namespace App\Filament\Resources\Suppliers\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Suppliers\SupplierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;
}
