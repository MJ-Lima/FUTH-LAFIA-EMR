<?php

namespace App\Filament\Resources\DrugCategories\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugCategories\DrugCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDrugCategories extends ListRecords
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
