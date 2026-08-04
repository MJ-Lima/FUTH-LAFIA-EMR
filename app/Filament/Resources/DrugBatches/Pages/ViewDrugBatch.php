<?php

namespace App\Filament\Resources\DrugBatches\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugBatches\DrugBatchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDrugBatch extends ViewRecord
{
    protected static string $resource = DrugBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
