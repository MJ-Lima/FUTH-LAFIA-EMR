<?php

namespace App\Filament\Resources\DrugBatches\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugBatches\DrugBatchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDrugBatch extends CreateRecord
{
    protected static string $resource = DrugBatchResource::class;
}
