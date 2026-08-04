<?php

namespace App\Filament\Resources\DrugCategories\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugCategories\DrugCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDrugCategory extends EditRecord
{
    protected static string $resource = DrugCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
