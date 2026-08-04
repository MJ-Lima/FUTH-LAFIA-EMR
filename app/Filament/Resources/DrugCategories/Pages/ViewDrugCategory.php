<?php

namespace App\Filament\Resources\DrugCategories\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugCategories\DrugCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDrugCategory extends ViewRecord
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
